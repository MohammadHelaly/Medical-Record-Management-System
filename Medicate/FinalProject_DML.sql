INSERT INTO medical_record_system.admin (admin_name,admin_email,admin_password) VALUES 
('admin','admin@admin.com',md5('admin')); 

INSERT INTO medical_record_system.patient  (pat_name,pat_email,pat_password,pat_phone,pat_city,pat_insured,pat_insurance_num) VALUES 
('test','test@test.com',md5('test'),'453675322','test','YES','765432123');