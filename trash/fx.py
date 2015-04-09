import json
import sympy.simplify as solv
from pprint import *
def abs_mod(n,k):
	return (k+(n % k)) % k

def step(curr_list):
	curr_list[0] += 1
	for i in range(len(curr_list)):
		if curr_list[i]>=z:
			curr_list[i]=0
			curr_list[i+1] +=1
	return curr_list
func = "f(a+b+c,a)+f((a+c),-(a+c))+f(a,b+c)+f(b,c)+f(-a,k-c)+f(-c,k)= f(a+b, a+c) +f(a, b) +f(a, -a)+f(c, -c) + f(-(a+c), k) ".replace(' ','')
print func
k=2
n=3
z=5
curr_list = n*[0]
zeros = ['00','01','02','03','10','20','30','04','40']
xes  = {}



def generate(func,n,z,curr_list):
	func = func.replace('k',str(k)).replace('a',str(curr_list[0])).replace('b',str(curr_list[1]))
	if(n>2):
		func = func.replace('c',str(curr_list[2]))
	ecc = func.split('=')
	ecc[0] = ')+'+ecc[0]+'+f('
	ecc[1] = ')+'+ecc[1]+'+f('

	# Left side
	left = ecc[0].split(')+f(')
	left.pop(0)
	left.pop(len(left)-1)
	num_left = len(left)

	#Right side
	right = ecc[1].split(')+f(')
	right.pop(0)
	right.pop(len(right)-1)
	num_right = len(right)

	#Splitting arguments
	left1 = left
	left  = []
	right1 = right
	right = []
	for item in left1:
		item = item.split(',')
		item[0] = abs_mod(solv(item[0]),z)
		item[1] = abs_mod(solv(item[1]),z)
		left.append((item[0],item[1]))

	for item in right1:
		item = item.split(',')
		item[0] = abs_mod(solv(item[0]),z)
		item[1] = abs_mod(solv(item[1]),z)
		right.append((item[0],item[1]))

	func = (left,right)

	return func
def get_final(curr_list,func,n,z):
	curr_list = step(curr_list)
	curr = generate(func,n,z,curr_list)
	left = curr[0]
	curr_dic = []
	for item in left:
		x = str(item[0])+str(item[1])
		curr_dic.append(x)

	left_dic = curr_dic

	right = curr[1]
	curr_dic = []
	for item in right:
		x = str(item[0])+str(item[1])
		curr_dic.append(x)

	right_dic = curr_dic
	final = (left_dic,right_dic)
	return final

def xstep():
	xes[0][1] += 1
	for i in range(len(xes)-1):
		if xes[i][1]>=z:
			xes[i][1]=0
			xes[i+1][1]+=1

def get_key(i):
	return xes[xes.keys()[i]]

def dir_step():
	xes[xes.keys()[0]] += 1
	for i in range(len(xes)):
		if get_key(i)>=z:
			xes[xes.keys()[i]]=0
			xes[xes.keys()[i+1]] +=1



curr_list[0] = -1
final = []
for i in range(z**(n)):
	final.append(get_final(curr_list,func,n,z))

for item in final:
	curr_rem = []
	for i in range(len(item[0])):
		for j in range(len(item[1])):
			if (item[0][i]==item[1][j]) and not(item[0][i] in curr_rem):
				curr_rem.append(item[0][i])
	#for val in curr_rem:
	#	item[1].remove(val)
	#	item[0].remove(val)		

for item in final:
	for val in item[0]:
		if not(val in xes) and not(val in zeros):
			xes.update({val:0})

	for val in item[1]:
		if not(val in xes) and not(val in zeros):
			xes.update({val:0})



total=0
pprint(final)
c = z**(len(xes))
print c
xes[xes.keys()[0]]=-1

			#Get CORE
func = 'f(a,b) + f(a+b,k)  = f(b,k) + f(a, b+k)'.replace(' ','')
n=2
curr_list = n*[0]
curr_list[0] = -1

final_core = []
for i in range(z**(n)):
	final_core.append(get_final(curr_list,func,n,z))

f = open('out'+str(k)+str(z), 'w')
i = -1
while i<c:
	i+=1
	dir_step()
	ls = []
	this = True
	for item in final:
		left = item[0]
		right = item[1]
		left_sum=0
		right_sum=0
		for val in left:
			try:
				left_sum += xes[val]
			except KeyError:
				pass
		for val in right:
			try:
				right_sum += xes[val]
			except KeyError:
				pass
		#print right_sum,left_sum
		if left_sum != right_sum:
			this = False
			break

	if this == True:
		this = False
		for item in final_core:
			left = item[0]
			right = item[1]
			left_sum=0
			right_sum=0
			for val in left:
				try:
					left_sum += xes[val]
				except KeyError:
					pass
			for val in right:
				try:
					right_sum += xes[val]
				except KeyError:
					pass
			if left_sum != right_sum:
				this = True
				break
	if this == True:
		s = 2*[0]
		s[0] = -1
		curr_rez = ''
		for i in range(2**z):
			s = step(s)
			st = str(s[1])+str(s[0])
			try:
				curr_rez += str(xes[st])
			except KeyError:
				curr_rez += '0'
		f.write(curr_rez+"\n")
		total +=1


print total