<?php

use App\Models\Codes236;
use Illuminate\Database\Seeder;

class Codes236Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Codes236::truncate();

        \DB::statement("INSERT INTO `chs_codes_2_36` (`id`, `field_1`, `field_2`) VALUES
			(1, '00', 'abcdefghijklmnopqrstuvwxyz0123456789'),
			(2, 'd6', '85b7lma6e2q9ufiz0vg4trnkxjpshc31odwy'),
			(3, 'j5', '103a87bt4ijcxlhsu9enmk6wpgqo5ryvdfz2'),
			(4, 'sy', 'eqpfg9x5cmudvho7n36krjiztw1as2y0lb48'),
			(5, '78', 'm8ahyz6xolbgdut2fje41rkncwq750vip9s3'),
			(6, 'vo', 'i0s6j79rpcge1qmvl3kox5fu2hyb8td4azwn'),
			(7, 'uh', 'ghi92mjn18e6plf3aqxtd4z0skbcy57wruov'),
			(8, 'fw', 'u25fxzk79dpy4qolvc8hw1am0s3jiebrg6tn'),
			(9, 'db', 'pd0cx861qn4si3lfybkw7zvjatuh5ermg92o'),
			(10, 'l1', 'dk8fy4oz3vw2qrlipua91jg5e0hcmn6xbts7'),
			(11, 'm9', 't1ufd4wgzhv07sb2al9cim5x8q63ypjkoern'),
			(12, '6l', 'oji35layxptceu01d4mg8w2qbzk679shrvnf'),
			(13, '8w', 'ohmb973swui10qvf6y45tzncx2elrdapj8kg'),
			(14, 'nc', 'mntk12v8wbc9i6x04ljp5zurqysh7dga3oef'),
			(15, '6n', 'sq9jo2khtl0d6if5zx8y3gcum47wab1pevnr'),
			(16, 'ge', 'lmhpnxorkdu0s415z937giyeqc2a6vtj8wfb'),
			(17, 'x6', '34yrxsngq5lp76dkbt8ov2wehzuic9a1mfj0'),
			(18, '27', 'zlw6uhp074otcx1938nik2agqymbefr5jsvd'),
			(19, 'am', '0zm7b1w2e89igftlnydkxusa56rov4chjqp3'),
			(20, 'eq', 'zgi5j8e4p7k6vuy2cnralshmf9boxwdq0t31'),
			(21, 'ee', '17uialxosz6k3w9y2q4bmctgrnfhd05jve8p'),
			(22, 'r4', 'svz037twn6lu2d1oarqbiygcpkh59mef4x8j'),
			(23, 'xr', 'of2m0gx49zhrywcunj5pveib71d36aq8lkts'),
			(24, '1e', 'pmx9w23iao4ge56f8hq7yk0brjsczdvtu1nl'),
			(25, 'xu', 'csbkr8law1xg0i6hfno7eymp29dq4tu3vj5z'),
			(26, '9r', '5nc7pw0k6ig3vjqzlumoxs2e4b1a8drt9fhy'),
			(27, '4w', 'gztmenpcly3jur0is12fh9bv7kdxa485o6wq'),
			(28, '3e', 'k2s165cf9rgnq0axedw7iulopbtz38hj4vmy'),
			(29, 'ho', 'kdvyg24xe6mrabhqfto1pcj53s0n8i7zwlu9'),
			(30, 'cc', '1sr8h9nuegwdfbqt4ylca3vkj0opx76z2mi5'),
			(31, 'l8', 'x9q1uj8g6dlc4p5anobsv27fzrihew0t3ykm'),
			(32, '9p', 'i9jchk7630v82uxdf51nztg4olrwsqmpebay'),
			(33, 'ng', 'e479h3sbfu52c8odkam0xg16virtlqpjzwyn'),
			(34, 'xg', 'fsau1bxmyvw5367qhcigne2ol0pdt4k98zrj'),
			(35, 'ti', 'q0epxdj3c4h62sw9mytlvizr7bnaof1kg58u'),
			(36, 'md', 'jrvqkon5m7dxg9sy12ef4bht0lpz8c3i6awu'),
			(37, 'h0', '5gtpei3q9auo74w1cbfdnh2y6vsxrl0zjmk8');");
    }
}
