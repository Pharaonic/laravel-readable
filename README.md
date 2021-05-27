<p align="center"><a href="https://pharaonic.io" target="_blank"><img src="https://raw.githubusercontent.com/Pharaonic/logos/main/readable.jpg"></a></p>

<p align="center">
<a href="https://github.com/Pharaonic/laravel-readable" target="_blank"><img src="http://img.shields.io/badge/source-pharaonic/laravel--readable-blue.svg?style=flat-square" alt="Source"></a> <a href="https://packagist.org/packages/pharaonic/laravel-readable" target="_blank"><img src="https://img.shields.io/packagist/v/pharaonic/laravel-readable?style=flat-square" alt="Packagist Version"></a><br>
<a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel->=6.0-red.svg?style=flat-square" alt="Laravel"></a> <img src="https://img.shields.io/packagist/dt/pharaonic/laravel-readable?style=flat-square" alt="Packagist Downloads"> <img src="http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Source">
</p>




#### Laravel Readable provides a quick and easy functions & blade directives.

- ###### Number. 				   		(1,020,304,050,607,080)

- ###### NumberToString. 	       ( seven thousand seven hundred twenty-one )  {PHP Extension intl}

- ###### HumanNumber.  	    	( 77K  ||  77.4K  ||  77.37K )

- ###### Decimal. 					  	 ( 60,708.547 )

- ###### DecInt. 					  	 ( 70.00 => 70 || 70.07 )

- ###### Date. 					  	   	( 24 April 2020 )

- ###### Time. 					  	   	( 15:20   ||   15:20:22   ||   03:20 PM   ||   03:20:22 PM )

- ###### DateTime. 					    ( Friday, April 24, 2020 05:20 PM )

- ###### DateTime Difference.    ( 27 years before )

- ###### Time Length.    	   	     ( 4 years 7 months 1 week 3 days 9 hours 50 minutes 10 seconds )

- ###### Short Time Length.    	   	     ( 4y 7m 1w 3d 9h 50m 10s )

- ###### DateTime Length.    	   ( 27 years - 1 week - 7 minutes - 7 seconds before )

- ###### File Size.    	 	 	 	 	 ( 70 GB )



## Install

Install the latest version using [Composer](https://getcomposer.org/):

```bash
$ composer require pharaonic/laravel-readable
```





## Usage

**Readable has the following methods & directives:**
- [ReadableNumber()](#ReadableNumber)
- [ReadableNumberToString()](#ReadableNumberToString)
- [ReadableHumanNumber()](#ReadableHumanNumber)
- [ReadableDecimal()](#ReadableDecimal)
- [ReadableDecInt()](#ReadableDecInt)
- [ReadableDate()](#ReadableDate)
- [ReadableTime()](#ReadableTime)
- [ReadableDateTime()](#ReadableDateTime)
- [ReadableDiffDateTime()](#ReadableDiffDateTime)
- [ReadableTimeLength()](#ReadableTimeLength)
- [ReadableDateTimeLength()](#ReadableDateTimeLength)
- [ReadableSize()](#ReadableSize)


<a name="ReadableNumber"></a>
##### ReadableNumber (int $number, string $delimiter = ',')
###### 1,020,304,050,607,080




<a name="ReadableNumberToString"></a>
##### ReadableNumberToString($input, string $lang = 'en')
###### EN => seven thousand seven hundred twenty-one
###### AR => سبعة آلاف و سبعة مائة و واحد و عشرون




<a name="ReadableHumanNumber"></a>

##### ReadableHumanNumber (int $number, bool $showDecimal = false, int $decimals = 0)
###### 77K  ||  77.4K  ||  77.37K



<a name="ReadableDecimal"></a>
##### ReadableDecimal ($number, int $decimals = 2, , string $point = '.', string $delimiter = ',')
###### 60,708.54



<a name="ReadableDecInt"></a>
##### ReadableDecInt ($number, int $decimals = 2, , string $point = '.', string $delimiter = ',')
###### 70 || 70.7



<a name="ReadableDate"></a>
##### ReadableDate ($date, string $timezone = null)
> $date = '24-04-2020' || Carbon Instance

###### 24 April 2020



<a name="ReadableTime"></a>
##### ReadableTime ($time, $is12Hours = false, bool $hasSeconds = false, string $timezone = null)
> $time = '15:20:22' || Carbon Instance

###### Has Seconds     	15:20:22    ||   03:20:22 PM
###### Hasn't Seconds    15:20     	||   03:20 PM 



<a name="ReadableDateTime"></a>
##### ReadableDateTime ($datetime, $is12Hours = false, bool $hasSeconds = false,  string $timezone = null)
> $datetime = '24-04-2020 17:20:32' || Carbon Instance

###### 12Hours + Has Seconds  	=> Friday, April 24, 2020 05:20:32 PM



<a name="ReadableDiffDateTime"></a>
##### ReadableDiffDateTime ($oldDateTime, $newDateTime = null, string $timezone = null)
> $oldDateTime = '24-04-2020 17:20:32' || Carbon Instance
> $newDateTime = '24-04-2020 17:20:32' || Carbon Instance || null (now)

###### 27 years before



<a name="ReadableTimeLength"></a>
##### ReadableTimeLength (int $seconds, string $comma = ' ', bool $short = false)
###### 4 years 7 months 1 week 3 days 9 hours 50 minutes 10 seconds
###### Comma => 4 years - 7 months - 1 week - 3 days - 9 hours - 50 minutes - 10 seconds
###### Short => 4y 7m 1w 3d 9h 50m 10s



<a name="ReadableDateTimeLength"></a>
##### ReadableDateTimeLength ($oldDateTime, $newDateTime = null, bool $fullForm = false, string $comma = ' ', string $timezone = null)
> $oldDateTime = '24-04-2020 17:20:32' || Carbon Instance
> $newDateTime = '24-04-2020 17:20:32' || Carbon Instance || null (now)

###### Short-Form  => 27 years before
###### Full-Form + Comma => 27 years - 1 week - 7 minutes - 7 seconds before



<a name="ReadableSize"></a>
##### ReadableSize (int $bytes, bool $decimal = true)
###### 70 GB



## License

[MIT license](LICENSE.md)
