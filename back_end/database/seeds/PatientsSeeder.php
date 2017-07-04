<?php

use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
            'id' => 1,
            'name' => 'patient1',
            'sex' => false,
            'age' => 30,
            'tel' => '135624312598',
            'wechat' => 'wechatusername',
            'state' => 0,
            'keyword' => 'keyword1',
            'pageurl' => 'http://localhost',
            'mark' => 'mark...',
            'price' => 1024,
            'advisory_date' => date('Y-m-d h:m:s', time()+3600*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+3800*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '1', 'disease_id' => '3']);
        DB::table('patient_doctor')->insert(['patient_id' => '1', 'doctor_id' => '1']);
        DB::table('patient_channel')->insert(['patient_id' => '1', 'channel_id' => '2']);
        DB::table('patient_advisory')->insert(['patient_id' => '1', 'advisory_id' => '3']);
        DB::table('patient_user')->insert(['patient_id' => '1', 'user_id' => '4']);

        DB::table('patients')->insert([
            'id' => 2,
            'name' => 'patient2',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'price' => 2048,
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '2', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '2', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '2', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '2', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '2', 'user_id' => '4']);

        DB::table('patients')->insert([
            'id' => 3,
            'name' => 'patient3',
            'sex' => true,
            'age' => 37,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'price' => 4096,
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+11500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '3', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '3', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '3', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '3', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '3', 'user_id' => '6']);

        DB::table('patients')->insert([
            'id' => 4,
            'name' => 'patient4',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+9600*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '4', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '4', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '4', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '4', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '4', 'user_id' => '5']);

        DB::table('patients')->insert([
            'id' => 5,
            'name' => 'patient5',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'price' => 1024,
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '5', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '5', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '5', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '5', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '5', 'user_id' => '4']);

        DB::table('patients')->insert([
            'id' => 6,
            'name' => 'patient6',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '6', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '6', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '6', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '6', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '6', 'user_id' => '6']);

        DB::table('patients')->insert([
            'id' => 7,
            'name' => 'patient7',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'price' => 10.6,
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '7', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '7', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '7', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '7', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '7', 'user_id' => '5']);

        DB::table('patients')->insert([
            'id' => 8,
            'name' => 'patient8',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '8', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '8', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '8', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '8', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '8', 'user_id' => '4']);

        DB::table('patients')->insert([
            'id' => 9,
            'name' => 'patient9',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '9', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '9', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '9', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '9', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '9', 'user_id' => '4']);

        DB::table('patients')->insert([
            'id' => 10,
            'name' => 'patient10',
            'sex' => true,
            'age' => 35,
            'tel' => '15264798652',
            'wechat' => 'wechatusernamewechatusername',
            'state' => 2,
            'keyword' => 'keywordkeyword',
            'pageurl' => 'http://localhost:8080',
            'mark' => 'mark...mark...',
            'advisory_date' => date('Y-m-d h:m:s', time()+10500*24),
            'arrive_date' => date('Y-m-d h:m:s', time()+10500*24),
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('patient_disease')->insert(['patient_id' => '10', 'disease_id' => '5']);
        DB::table('patient_doctor')->insert(['patient_id' => '10', 'doctor_id' => '3']);
        DB::table('patient_channel')->insert(['patient_id' => '10', 'channel_id' => '3']);
        DB::table('patient_advisory')->insert(['patient_id' => '10', 'advisory_id' => '2']);
        DB::table('patient_user')->insert(['patient_id' => '10', 'user_id' => '6']);
    }
}
