-- データベース名 mysite

-- ACCOUNTSテーブル作成
CREATE TABLE ACCOUNTS (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(20) NOT NULL UNIQUE,
    PASS VARCHAR(20) NOT NULL
)

-- ACCOUNTSテーブルにユーザーを登録
INSERT INTO ACCOUNTS (NAME, PASS) VALUES ('', '')

-- BLOGSテーブルを作成
CREATE TABLE BLOGS (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    USER_ID INTEGER NOT NULL REFERENCES ACCOUNTS(ID),
    TITLE VARCHAR(100) NOT NULL,
    TEXT VARCHAR(400) NOT NULL,
    IMG VARCHAR(100),
    CREATE_TIME DATETIME NOT NULL
)

-- WORKSテーブルを作成
CREATE TABLE WORKS (
    ID INTEGER PRIMARY KEY AUTO_INCREMENT,
    USER_ID INTEGER NOT NULL REFERENCES ACCOUNTS(ID),
    TITLE VARCHAR(100) NOT NULL,
    SKILL VARCHAR(100) NOT NULL,
    TEXT VARCHAR(400) NOT NULL,
    IMG VARCHAR(100) NOT NULL,
    LINK1 VARCHAR(100),
    LINK2 VARCHAR(100),
    LINK_TEXT1 VARCHAR(100),
    LINK_TEXT2 VARCHAR(100)
)
