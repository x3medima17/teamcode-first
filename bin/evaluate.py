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
import sys

db = torndb.Connection("localhost", "isef",user="root",password="salapia")

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


def load_testcases(test_info):
    testcases = json.loads(test_info)
    if ACTIVE_MODE == '0':
        for i in range(1,len(testcases)+1):
            if str(testcases[str(i)]) != '0':
                del testcases[str(i)]
    return testcases

def evaluate(ssid,problem_id,extension,user_id,ACTIVE_MODE):
    #Get problem data
    problem = db.get("SELECT * FROM problems WHERE id="+str(problem_id))
    timelimit = problem["timelimit"]
    memory = problem["memory"]
    testcases = load_testcases(problem["test_info"])
    problem_id = problem["id"]
    problem_title = problem["title"]
    contest_id = problem["contest_id"]
    script = problem["script"]
    data = []
    path = "../contests/"+str(contest_id)+"/"+str(problem_id)+"/"
    tmp = "tmp/"+str(ssid)+"/"
    #Preparing files
    if script=='1':
        copy2(path+"script",tmp+"script")

    #Iterating through testcases

    for i in range(1,len(testcases)+1):
        ext = [".out",".in",".ok"]
        for e in ext:
            if os.path.isfile(tmp+problem_title+e):
                call(["rm",tmp+problem_title+e])
            
        copy2(path+str(i)+".in",tmp+problem_title+".in")
        #Run
        start = time()
        process = Popen(["bash","run.sh",str(tmp),str(int(timelimit)+1),str(memory),"file"], stdout=PIPE)
        out = process.communicate()[0]
        end = time()

        #Timelimit
        if end-start>float(timelimit):
            output = {"Runtime":end-start,
                    "Score":0,
                    "Result":"Timelimit"
                }
            data.append(output)
            continue

        #Runtime

        if os.path.isfile(tmp+problem_title+'.out'):
            pass
        else:
            output = {"Runtime":end-start,
                    #"Score":0,
                    "Result":"Runtime error"
                }
            data.append(output)
            continue    

        #Compare files
        #Special script
        if script=='1':
            process = Popen(["bash","run.sh",str(tmp),str(int(timelimit)+1),str(memory),"script"], stdout=PIPE)
            exit_code = os.waitpid(process.pid, 0)
            if process.communicate()[0]=="True":
                score = testcases[i]
                result = "Correct"
            else:
                score = 0
                result = "Wrong"

            output = {"Runtime":end-start,
                    "Score":score,
                    "Result":result
                    }
            data.append(output)
            continue

        #Simple case
        copy2(path+str(i)+".ok",tmp+problem_title+".ok")
        #Trim files
        trim(tmp+problem_title)
            
        if filecmp.cmp(tmp+problem_title+".ok", tmp+problem_title+".out")==True:
            output = {"Runtime":end-start,
                    #"Score":testcases[str(i)],
                    "Result":"Correct"
                    }
            data.append(output)
            continue
        output = {"Runtime":end-start,
                    #"Score":0,
                    "Result":"Wrong"
                    }
        data.append(output)
        continue

    for e in ext:
        if os.path.isfile(tmp+problem_title+e):
            call(["rm",tmp+problem_title+e])
            
    mode = int(ACTIVE_MODE)
    data = {
        "lang":extension,
        "problem_id":problem_id,
        "contest_id":contest_id,
        "user_id":user_id,
        "ACTIVE_MODE":mode,
        "result":data

    }
    result = json.dumps(data)
    submission_id = db.execute("""
        INSERT INTO submissions (problem_id,user_id,lang,contest_id,result,ACTIVE_MODE,total,time) 
        VALUES (%s,%s,%s,%s,%s,%s,%s,%s)
        """,(str(problem_id)),str(user_id),str(extension),str(contest_id),str(result),str(mode),str(0),str(0))

    Popen(["sh","clean.sh",str(user_id),str(ssid),str(extension),str(submission_id)])
    
ssid = sys.argv[1]
problem_id = sys.argv[2]
extension = sys.argv[3]
user_id = sys.argv[4]
ACTIVE_MODE = sys.argv[5]

evaluate(ssid,problem_id,extension,user_id,ACTIVE_MODE)
