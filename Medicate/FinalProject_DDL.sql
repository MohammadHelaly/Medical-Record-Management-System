CREATE DATABASE IF NOT EXISTS medical_record_system;

CREATE TABLE IF NOT EXISTS medical_record_system.admin (
admin_id INT NOT NULL  , 
admin_name TEXT NOT NULL ,
admin_email VARCHAR(255) NOT NULL , 
admin_password VARCHAR(255) NOT NULL ,  
PRIMARY KEY (admin_id));

CREATE TABLE IF NOT EXISTS medical_record_system.patient (
pat_id INT AUTO_INCREMENT, 
pat_name TEXT NOT NULL,
pat_email VARCHAR(255) NOT NULL, 
pat_password VARCHAR(255) NOT NULL,
pat_phone INT NOT NULL,
pat_city TEXT NOT NULL,
pat_insured TEXT NOT NULL,
pat_insurance_num INT,  
PRIMARY KEY (pat_id));

CREATE TABLE IF NOT EXISTS medical_record_system.patient_conditions (
pat_id INT NOT NULL,  
pat_condition TEXT DEFAULT NULL,
PRIMARY KEY (pat_id,pat_condition(255)));

CREATE TABLE IF NOT EXISTS medical_record_system.prescriptions (
pat_id INT NOT NULL,
doc_id INT NOT NULL,  
prescription TEXT NOT NULL,
pres_date DATE,
PRIMARY KEY (pat_id,doc_id,prescription(255)));

CREATE TABLE IF NOT EXISTS medical_record_system.appointment (
app_id INT UNIQUE AUTO_INCREMENT,
pat_id INT,
doc_id INT, 
app_date DATE NOT NULL,
app_desc VARCHAR(255) NOT NULL,
clinic_id INT NOT NULL ,
app_payment INT NOT NULL,
PRIMARY KEY (app_id,pat_id,doc_id,clinic_id));

CREATE TABLE IF NOT EXISTS medical_record_system.doctor (
doc_id INT UNIQUE AUTO_INCREMENT, 
doc_name TEXT NOT NULL,
doc_email VARCHAR(255) NOT NULL, 
doc_password VARCHAR(255) NOT NULL,
doc_phone INT NOT NULL,
doc_city TEXT NOT NULL,
PRIMARY KEY (doc_id));

CREATE TABLE IF NOT EXISTS medical_record_system.doctor_status (
doc_id INT NOT NULL, 
doc_status TEXT NOT NULL ,
doc_status_date DATE NOT NULL , 
PRIMARY KEY (doc_id,doc_status(255) ,doc_status_date));
	
CREATE TABLE IF NOT EXISTS medical_record_system.clinic (
clinic_id INT, 
clinic_city TEXT NOT NULL,
clinic_address VARCHAR(255) NOT NULL,  
PRIMARY KEY (clinic_id,clinic_city(255)));

ALTER TABLE appointment ADD CONSTRAINT appointment_fk1 FOREIGN KEY (pat_id) REFERENCES patient(pat_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE appointment ADD CONSTRAINT appointment_fk2 FOREIGN KEY (clinic_id) REFERENCES clinic(clinic_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE appointment ADD CONSTRAINT appointment_fk3 FOREIGN KEY (doc_id) REFERENCES doctor(doc_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE patient_conditions ADD CONSTRAINT patient_conditions_fk FOREIGN KEY (pat_id) REFERENCES patient(pat_id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE doctor_status ADD CONSTRAINT doctor_status_fk FOREIGN KEY (doc_id) REFERENCES doctor(doc_id) ON DELETE CASCADE ON UPDATE CASCADE; 
 
ALTER TABLE prescriptions ADD CONSTRAINT prescriptions_fk1 FOREIGN KEY (pat_id) REFERENCES patient(pat_id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE prescriptions ADD CONSTRAINT prescriptions_fk2 FOREIGN KEY (doc_id) REFERENCES doctor(doc_id) ON DELETE CASCADE ON UPDATE CASCADE;