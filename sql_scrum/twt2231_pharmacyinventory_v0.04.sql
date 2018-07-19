/*add new fields - trans_dt, trans_time*/
ALTER TABLE transactions ADD COLUMN trans_dt DATE;
ALTER TABLE transactions ADD COLUMN trans_time CHAR(5);