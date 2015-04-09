#!/usr/bin/env python
import os.path
import tornado.ioloop
from tornado.ioloop import IOLoop
import tornado.web
import pymongo
from bson.objectid import ObjectId
import torndb
import json
from time import time
from tornado import gen
from base64 import b64decode
from math import sqrt 
import shlex
from subprocess import Popen, PIPE, call
import os
from shutil import copy2
import filecmp
import multiprocessing


db = torndb.Connection("localhost", "isef",user="root",password="salapia")

ACTIVE_MODE = True

ROOT = "/home/ubuntu/isef/" 

def trim(filee):
    data = []
    f = open(filee+".ok",'r')
    a = f.readlines()
    f.close()
    if ("\n" in a[len(a)-1]):
        a[len(a)-1] = a[len(a)-1][:len(a[len(a)-1])-1]
        f = open(filee+'.ok','w')
        for item in a:
            f.write(item)
            data.append(item)

    f = open(filee+".out",'r')
    a = f.readlines()
    f.close()
    if len(a)>0:
        if ("\n" in a[len(a)-1]):
            a[len(a)-1] = a[len(a)-1][:len(a[len(a)-1])-1]
            f = open(filee+'.out','w')
            for item in a:
                f.write(item)   


def get_last_id():
    data = db.get("SELECT id FROM submissions ORDER by id DESC LIMIT 1")
    return data["id"]

def gen_result(status,msg):
    data = {
        "status":status,
        "message":msg
    }
    return json.dumps(data)

def decoder(secret):
    key = 17
    return str(int(sqrt(int(b64decode(b64decode(secret))))/key))

def load_testcases(test_info):
    testcases = json.loads(test_info)
    if ACTIVE_MODE == False:
        for i in range(1,len(testcases)+1):
            if str(testcases[str(i)]) != '0':
                del testcases[str(i)]
    return testcases


class UploadHandler(tornado.web.RequestHandler):
    def post(self):
        #Set data
        allowed = ["pas","c","cpp"]
        banned = ["shell","system","exec"]

        #Get  information
        user_id = decoder(self.get_arguments('secret')[0])
        problem_id = self.get_arguments('problem_id')[0]
        file1 = self.request.files['file'][0]
        original_fname = file1['filename']
        extension = os.path.splitext(original_fname)[1][1:]

        content = file1['body']

        #Check for banned words 
        if any(word in content for word in banned):
            self.write(gen_result("1","Banned"))
            return

        #Check extension
        if not(extension in allowed):
            self.write(gen_result("2","Extension"))
            print extension
            return

        #Check user and problem
        n=0
        n += len(db.query("SELECT id FROM users WHERE id="+str(user_id)))
        problem = db.get("SELECT id,title,contest_id FROM problems WHERE id="+str(problem_id)+" LIMIT 1")
        if problem != None:
            n +=1 
        if n!=2:
            self.write(gen_result("3","Invalid user or problem."+problem_id))
            return

        #Create session
        ssid = str(time())
        fname = "file"
        final_filename= str(fname)
        path = "tmp/"+ssid+"/"
        #Save file
        os.mkdir(path)
        file1["body"] = file1["body"].replace(problem["title"].upper()+".IN",problem["title"]+".in")
        file1["body"] = file1["body"].replace(problem["title"].upper()+".OUT",problem["title"]+".out")
        output_file = open(path+final_filename+"."+extension, 'w')
        output_file.write(file1['body'])
        output_file.close()

        #Compile
        process = Popen(["bash","compile.sh",ssid,extension], stdout=PIPE)
        exit_code = os.waitpid(process.pid, 0)
        output = process.communicate()[0]
        if output!='0\n':
            self.write(gen_result("4","Compile Error"))
            return

        self.write(gen_result("0","Submission accepted."))
        #Evaluate
        #multiprocessing.Process(name="evaluate",target=evaluate(ssid,problem_id,extension,user_id)).start()
        contest_id = problem["contest_id"]
        self.write(problem_id)
        ACTIVE_MODE = db.get("SELECT ACTIVE_MODE FROM contests WHERE id=%s",str(contest_id))["ACTIVE_MODE"]
        #self.write(ACTIVE_MODE)
        Popen(["python","evaluate.py",str(ssid),str(problem_id),str(extension),str(user_id),str(ACTIVE_MODE)])
        #result = evaluate(ssid,problem_id,extension,user_id)
        #self.write(str(result))
        
        #self.finish("   file" + final_filename + " is uploaded")

class MainHandler(tornado.web.RequestHandler):
    def post(self):
        pass

class MyHandler(tornado.web.RequestHandler):
    @tornado.web.asynchronous
    @gen.engine
    def get(self):
        print("sleeping .... ")
        # Do nothing for 5 sec
        loop = IOLoop.instance()
        yield gen.Task(loop.add_timeout, time() + 5)
        self.write("I'm awake!")
        self.finish()

class UploadBox(tornado.web.RequestHandler):
    def get(self):
        #self.write("hello")
        self.render(ROOT+"upload_box.php")

handlers = [
    (r"/", MainHandler),
    (r"/upload",UploadHandler),
    (r"/web",MyHandler),
    (r"/upload_box",UploadBox) 
]
 

application = tornado.web.Application(handlers)


if __name__ == "__main__":
    application.listen(8888)
    tornado.ioloop.IOLoop.instance().start()