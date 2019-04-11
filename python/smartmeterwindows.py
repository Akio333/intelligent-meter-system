import datetime
import os
import platform
import random
import time
import urllib
import requests
from urllib.request import urlopen
from pprint import pprint
from pymongo import MongoClient
import signal
import datetime


def Exit_gracefully(signal, frame):
    x=input("Do you really want to quit ?? [y/n] : ")
    if x=="y":
        exit(0)

v = 230
i = 0
f = 50
k = 0
pwrarray = []
dmpcnt = 30  
mtrreading = 0
healthchecker = ""

monthh = datetime.datetime.now().strftime("%m")
month = int(monthh)
mon=""
if month == 1:
    mon="JAN"
elif month== 2:
    mon="FEB"
elif month== 3:
    mon="MAR"
elif month== 4:
    mon="APR"
elif month== 5:
    mon="MAY"
elif month== 6:
    mon="JUN"
elif month== 7:
    mon="JUL"
elif month== 8:
    mon="AUG"
elif month== 9:
    mon="SEP"
elif month== 10:
    mon="OCT"
elif month== 11:
    mon="NOV"
elif month== 12:
    mon="DEC"
else:
    print("system date error..")
    exit(0)

conid=input("Enter consumer ID :")
client = MongoClient("mongodb://localhost:27017")
db = client.IMS
colcon =db.consumer
mqry = {"Consumer_Id":conid}
x=colcon.find_one(mqry)
meterid=""
if x != None:
    meterid = x["meter_no"]
    healthchecker="Connected"
else:
    print("Wrong Consumer ID")
    exit(0)

def getElec(e):
    global v
    global i
    v = random.randint(180, 270)
    i = round(random.uniform(0.2, 0.6), 1)
    if e == 1:
        return i
    elif e == 2:
        return v
    else:
        return "Meter Fault"


def calcPower():
    global healthchecker
    v, i = getElec(2), getElec(1)
    if v == "Meter Fault":
        healthchecker = v
    else:
        p = v * i
    return round(p, 1)


def getMtrReading():
    global pwrarray
    global mtrreading
    pwravg = sum(pwrarray) / len(pwrarray)
    newmtrreading = (pwravg / 1000) + mtrreading
    mtrreading = newmtrreading
    return newmtrreading


def getHealth():
    pass

def mongoUpdate():
    client = MongoClient()
    db = client.IMS
    colmtr = db.meter
    global healthchecker
    global k
    mtrd="%.2f" % round(mtrreading,2)
    mtrread=str(mtrd)
    chk = {"meter_no":meterid}
    nval = {"$set":{mon:mtrread,"Status":"1"}}
    k = colmtr.update_one(chk,nval)


def disOnMeter():
    global mtrreading
    os.system('cls')
    print("=====================================================")
    print("=====================================================")
    print("============ Bharat Electricity Board ===============")
    print("=====================================================")
    print("\t Meter ID: ", meterid)
    print("\t Date: ", meterdt, "\t KW: ", power / 1000)
    print("\t Reading: ", mtrreading)
    print("\t Health: ", healthchecker)
    print("=====================================================")
    print("=====================================================")

loopcnt = 0
while True:
    power = calcPower()
    pwrarray += [power]
    meterfw = platform.system()[2]
    meterdt = datetime.datetime.now().strftime("%D-%m-%Y-%H:%M")
    loopcnt = loopcnt + 1
    if loopcnt == dmpcnt:
        loopcnt = 0
        dmpme = 'yes'
        mtrreading = getMtrReading()
        pwrarray = []
    else:
        dmpme = 'no'

    postvalues = {
        'mid': meterid,
        'dt': meterdt,
        'p': power,
        'v': v,
        'i': i,
        'fw': meterfw,
        'mr': mtrreading,
        'dmp': dmpme
    }
    postdata = urllib.parse.urlencode(postvalues)
    
    disOnMeter()
    mongoUpdate()
    time.sleep(0.02)
    signal.signal(signal.SIGINT, Exit_gracefully)