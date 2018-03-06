-- ----------------------------------------------------------------
--  TABLE tbl_brands
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_brands
(
   brand_id      varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   brand_name    varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   cat_id        varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   PRIMARY KEY(brand_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_cart
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_cart
(
   cart_id             varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   user_id             varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   total_price         decimal(10, 0) NOT NULL,
   ip_addr             varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   cart_status         varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   created_datetime    datetime(0) NOT NULL,
   PRIMARY KEY(cart_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_cart_items
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_cart_items
(
   cart_id       varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   prod_id       varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   qty           int(10) NOT NULL,
   unit_price    decimal(10, 0) NOT NULL
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_categories
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_categories
(
   cat_id      varchar(100)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NOT NULL,
   cat_name    varchar(200)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NOT NULL,
   PRIMARY KEY(cat_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_item_images
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_item_images
(
   item_id       varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   seq_id        int(100) NOT NULL,
   image_name    varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_items
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_items
(
   item_id          varchar(100)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL,
   item_name        varchar(500)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL,
   short_desc       text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
   item_desc        text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
   item_prod        varchar(100)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL,
   item_price       decimal(10, 0) NOT NULL,
   item_stock       int(10) NOT NULL,
   ref_id           varchar(100)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL,
   item_keywords    varchar(100)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL,
   status           varchar(10)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL,
   rating           int(10) NOT NULL DEFAULT 5,
   badge            varchar(10)
                    CHARACTER SET latin1
                    COLLATE latin1_swedish_ci
                    NOT NULL
                    DEFAULT 'NEW',
   created_date     datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(item_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_newsletter_signup
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_newsletter_signup
(
   email         varchar(200)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   added_date    datetime(0) NOT NULL,
   PRIMARY KEY(email)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_orders
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_orders
(
   order_id            varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   cart_id             varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   user_id             varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   cart_total          decimal(10, 0) NOT NULL,
   tax_amount          decimal(10, 0) NOT NULL,
   order_total         decimal(10, 0) NOT NULL,
   billing_name        varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   billing_company     varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NULL,
   billing_email       varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   billing_contact     varchar(20)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   billing_address     varchar(500)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   delivery_name       varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   delivery_company    varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NULL,
   delivery_email      varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   delivery_contact    varchar(20)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   delivery_address    varchar(500)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   delivery_note       varchar(200)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NULL,
   payment_method      varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   order_datetime      datetime(0) NOT NULL,
   order_status        varchar(100)
                       CHARACTER SET latin1
                       COLLATE latin1_swedish_ci
                       NOT NULL,
   PRIMARY KEY(order_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_product_images
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_product_images
(
   prod_id       varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL,
   seq_id        int(100) NOT NULL,
   image_name    varchar(100)
                 CHARACTER SET latin1
                 COLLATE latin1_swedish_ci
                 NOT NULL
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_product_reviews
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_product_reviews
(
   review_id      varchar(100)
                  CHARACTER SET latin1
                  COLLATE latin1_swedish_ci
                  NOT NULL,
   prod_id        varchar(100)
                  CHARACTER SET latin1
                  COLLATE latin1_swedish_ci
                  NOT NULL,
   rating         int(100) NOT NULL,
   review         text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
   name           varchar(200)
                  CHARACTER SET latin1
                  COLLATE latin1_swedish_ci
                  NOT NULL,
   email          varchar(200)
                  CHARACTER SET latin1
                  COLLATE latin1_swedish_ci
                  NOT NULL,
   review_date    datetime(0) NOT NULL,
   PRIMARY KEY(review_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_products
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_products
(
   prod_id         varchar(100)
                   CHARACTER SET latin1
                   COLLATE latin1_swedish_ci
                   NOT NULL,
   prod_name       varchar(500)
                   CHARACTER SET latin1
                   COLLATE latin1_swedish_ci
                   NOT NULL,
   prod_cat        varchar(100)
                   CHARACTER SET latin1
                   COLLATE latin1_swedish_ci
                   NOT NULL,
   prod_brand      varchar(100)
                   CHARACTER SET latin1
                   COLLATE latin1_swedish_ci
                   NOT NULL,
   ref_id          varchar(100)
                   CHARACTER SET latin1
                   COLLATE latin1_swedish_ci
                   NOT NULL,
   status          varchar(10)
                   CHARACTER SET latin1
                   COLLATE latin1_swedish_ci
                   NOT NULL,
   created_date    datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(prod_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_users
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_users
(
   user_id                varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   first_name             varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   last_name              varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   email                  varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   contact_no             varchar(50)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   password               varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   billing_house_no       int(10) NULL,
   billing_street         varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NULL,
   billing_city           varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NULL,
   billing_region         varchar(100)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NULL,
   billing_postal_code    varchar(50)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NULL,
   billing_country        text
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NULL,
   registered_date        datetime(0) NOT NULL,
   user_status            varchar(10)
                          CHARACTER SET latin1
                          COLLATE latin1_swedish_ci
                          NOT NULL,
   PRIMARY KEY(user_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_web_inquiry
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_web_inquiry
(
   inq_id      varchar(100)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NOT NULL,
   name        varchar(100)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NOT NULL,
   email       varchar(200)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NOT NULL,
   company     varchar(200)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NULL,
   subject     varchar(500)
               CHARACTER SET latin1
               COLLATE latin1_swedish_ci
               NOT NULL,
   message     text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
   inq_date    datetime(0) NOT NULL,
   PRIMARY KEY(inq_id)
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


-- ----------------------------------------------------------------
--  TABLE tbl_wishlist
-- ----------------------------------------------------------------

CREATE TABLE phonerepairpartsdb.tbl_wishlist
(
   user_id    varchar(100)
              CHARACTER SET latin1
              COLLATE latin1_swedish_ci
              NOT NULL,
   prod_id    varchar(100)
              CHARACTER SET latin1
              COLLATE latin1_swedish_ci
              NOT NULL
)
ENGINE MyISAM
COLLATE 'latin1_swedish_ci'
ROW_FORMAT DEFAULT;


