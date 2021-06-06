CREATE TABLE comments (
   ID BIGINT NOT NULL AUTO_INCREMENT ,
   comment TEXT NOT NULL ,
   comment_author INT NOT NULL ,
   comment_post INT NOT NULL ,
   date_created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
   date_modified DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP 
   parent_comment INT NULL ,
   PRIMARY KEY (ID)
 ) 

 CREATE TABLE thumbs (
     ID BIGINT NOT NULL AUTO_INCREMENT,
     post_id BIGINT NOT NULL,
     comment_id BIGINT NOT NULL,
     thumbs_up INT NOT NULL DEFAULT 0,
     thumbs_down INT NOT NULL DEFAULT 0,
 )

--  add thumbs beside the posts/comment;