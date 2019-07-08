#!/usr/bin/expect -f
#send "Enter your password:" 
#set password [lindex $argv 0]
#send "$password\r\n"
#puts "args : $password"
#set a='prompt "Enter an answer" silence 10'

#Enter an answer: test  
#echo Answer was "$a"   

set password VMF9>4z@426Y
set ipArr  {"100.73.13.15" "100.73.13.5"}
set len [llength $ipArr]
for {set i 0} {$i<[llength $ipArr]} {incr i} {
    #puts "[lindex $ipArr $i]"
    set ip "[lindex $ipArr $i]"
    spawn scp -r qitui root@$ip:/data/www/
    expect "root@$ip's password:"
    send "$password\r"
    send "exit\r"
    expect eof   
}
#foreach  i  in $ipArr  {
#   puts "$i"
#}

#spawn scp -r  /Users/tianyi/main.go root@100.73.13.5:/root/
#expect "root@100.73.13.5's password:"
#send "$password\r"
#send "exit\r"
#expect eof
