
<%
	'if isNull(session("Rights")) or session("Rights") < 3 then
	'	response.redirect "admin/notadmin.asp"
	'end if
%>


<html>
<head>
<title> Look at Session Contents</title>
</head>
<body>
<% 
'dim mappath
'mappath = Server.mappath(Session("ListFile"))
'session("MapPath") = mappath
session("LloydProdID") = "999"
on error resume next
Dim Item
For Each Item in Session.Contents
   
   if (instr(Item,"Connection") = 0) and (instr(Item,"RuntimeUserName") = 0) and (instr(Item,"RuntimePassword") = 0) then
      response.write(Item & " = " & Session.Contents(Item) & "<br>")
   end if
Next
response.write("Request Level Array <br>")
ReqLevelArray = Session("ReqLevArray")

        for ctr=0 to ubound(ReqLevelArray)
            response.write(ReqLevelArray(ctr) & "<br>")
        next

response.write("Yes I hear you.")
dim acroArray
acroArray = session("aRay")
Dim ctr
aRsize = ubound(acroArray,2)
for ctr = 1 to aRsize
  response.write("aRay item:" & ctr & acroArray(ctr) & "<br>")
next
response.write("size: " & aRay)

Response.write("CArroll: " & Session("Carroll_ConnectionString") )
%>


</body>
</html>