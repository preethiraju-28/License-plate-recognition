import cv2
import imutils
import numpy as np
import pytesseract
import pymysql
from _datetime import datetime

#Connect to database
db = pymysql.connect(host = "localhost", user = "root", passwd = "",database = "SRP" )
mycursor = db.cursor()

#Image recognition
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

img = cv2.imread('test.jpeg', cv2.IMREAD_COLOR)
img = cv2.resize(img, (600, 400))

gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
gray = cv2.bilateralFilter(gray, 13, 15, 15)

edged = cv2.Canny(gray, 30, 200)
contours = cv2.findContours(edged.copy(), cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
contours = imutils.grab_contours(contours)
contours = sorted(contours, key=cv2.contourArea, reverse=True)[:10]
screenCnt = None

for c in contours:

    peri = cv2.arcLength(c, True)
    approx = cv2.approxPolyDP(c, 0.018 * peri, True)

    if len(approx) == 4:
        screenCnt = approx
        break

if screenCnt is None:
    detected = 0
    print("No contour detected")
else:
    detected = 1

if detected == 1:
    cv2.drawContours(img, [screenCnt], -1, (0, 0, 255), 3)

mask = np.zeros(gray.shape, np.uint8)
new_image = cv2.drawContours(mask, [screenCnt], 0, 255, -1, )
new_image = cv2.bitwise_and(img, img, mask=mask)

(x, y) = np.where(mask == 255)
(topx, topy) = (np.min(x), np.min(y))
(bottomx, bottomy) = (np.max(x), np.max(y))
Cropped = gray[topx:bottomx + 1, topy:bottomy + 1]

text = pytesseract.image_to_string(Cropped, config='--psm 11')
final  = text.strip()
final = final.replace(" ", "")
final = final.split('|')[0]

vehicleNo = text
img = cv2.resize(img, (500, 300))
Cropped = cv2.resize(Cropped, (400, 200))
#cv2.imshow('car', img)
#cv2.imshow('Cropped', Cropped)

t = datetime.now()
stmt = "UPDATE basic SET second_time = %s WHERE vehicle_no = %s"
val = (t, final)
mycursor.execute(stmt, val)

query1 = "SELECT first_time FROM basic WHERE vehicle_no = %s"
mycursor.execute(query1, final)
time1 = mycursor.fetchone()[0]

query2 = "SELECT second_time FROM basic WHERE vehicle_no = %s"
mycursor.execute(query2, final)
time2 = mycursor.fetchone()[0]

timediff = time2-time1
hour = timediff.total_seconds() /3600
speed = 5/hour
query3 = "UPDATE basic SET speed = %s WHERE vehicle_no = %s"
val3 = (speed, final)
mycursor.execute(query3, val3)

query4 = "SELECT fine FROM basic WHERE vehicle_no = %s"
mycursor.execute(query4, final)
fine = mycursor.fetchone()

if speed < 10:
    fine =+ 0
elif speed <30:
    fine =+ 500
else:
    fine =+1000


query5 = "UPDATE basic SET fine = %s WHERE vehicle_no = %s"
val5 = (fine, vehicleNo)
mycursor.execute(query5,val5)
db.commit()

print("SUCCESS")

cv2.waitKey(0)
cv2.destroyAllWindows()