; Access control config
; this file has a format of php .ini file
; IMPORTANT: keep this outsite the web dir
; This file should never be accessible with a browser
;
; Normally you don't have to edit this file
; unless new permission types are added

; base group, every group inherits from it
[everyone]
view_question = A
view_answers = A
view_comments = A
login = A
read = A

;
;unregistered on not logged in user
[guest]
parent_id = everyone
register = A
ask = D
answer = D
comment = D
vote = D
accept = D

            
;
;users who registered but not yet confirmed email address
[unactivated]
parent_id = everyone
register = A
edit_profile = A
register_email = A
ask = D
answer = D
comment = D

            
;
;regular member
[registered]
parent_id = everyone
register = D
change_password = A
edit_profile = A
add_blog_post = A
post_by_email = A
ask = A
answer = A
comment = D
vote = A
accept = A

   
            
;
;regular member
[virtual]
parent_id = registered
         
;
;can moderate some resources 
;but still needs specific permissions on resource
[moderator]
parent_id = registered
edit_question = A
edit_answer = A
delete_question = A
delete_answer = A
delete_comment = A
retag = A
comment = A
ban_user = A
unban_user = A
close_question = A
edit_any_comment = A


            
;
;can do most of the things
[administrator]
parent_id = moderator
register = D
change_password = A
edit_profile = A
add_blog_post = A
post_by_email = A
ask = A
answer = A
comment = A
rate_question = A
rate_answer = A
accept = A
rate = A
delete_question = A
delete_answer = A
ban_user = A
shred_user = A
change_user_role = A
make_sticky = A
edit_any_profile = A
            
;
;user caught spamming
[spammer]
parent_id = registered
ask = D
answer = D
comment = D

            
;
;user privileges suspended
[suspended]
parent_id = everyone
register = D
ask = D
answer = D
comment = D
vote = D
accept = D
            
;
;user account marked as deleted
[deleted]
register = D
ask = D
answer = D
comment = D
vote = D
accept = D
login = D
            
;
;Users without email address. 
;Usually they joined with 3rd party auth like Twitter
;or FriendConnect
[external_auth]
parent_id = registered
register_email = A


; external user who has not confirmed
; an email address
[unactivated_external]
parent_id = registered

