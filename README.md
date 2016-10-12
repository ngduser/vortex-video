
#Video Vortex Project

The Video Vortex Project is designed to create a self contained online accessible Video Streaming Content Management System with Content Delivery (CMS/CD) as an open web application written entirely in PHP. The purpose is to allow livestreaming, video hosting, and playback viewing integrated together within a simple system designed to run on the free tiers of an Amazon EC2 instance and S3 bucket so that livestreamers, video bloggers, and other content providers have the option of easy self hosting on an open system under their own control.

An example test system is available at www.videovortex.stream. 


##Getting Started

###This project uses the following technologies

-Linux Server Distro (Kernel 4.5.7 tested)

-Apache 2.4.23

-MySQL 5.5.49

-PHP 5.5.30

-NodeJS 5.0.1

-Nginx 1.11.0

-ffmpeg-3.0.2

-AWS SDK for PHP v3

-Bootstrap


###Install Linux Server Distribution and Preform Updates

Follow distribution directions. This guide will use Ubuntu but modify based on chosen distribution.

###Compile nginx with RTMP and Secure SSL Modules

Use provided nginx script. 

###Install nginx and all Dependencies 

Make sure configuration file matches example provided and only port 1935 is being used otherwise it will conflict with Apache2.

###Install AMP Stack of Apache2, MySQL, and PHP along with all Dependancies

As shown at https://help.ubuntu.com/community/ApacheMySQLPHP.

###Install NodeJS and All Dependencies using Package Manager

As shown at https://nodejs.org/en/download/package-manager/.

###Install and Configure AWS SDK for PHP

Follow https://aws.amazon.com/sdk-for-php/. Be sure to use IAM to assign the role of getObject for the bucket key instead of using your user credentials which could potentially expose your account authorizations.

###Install ffmpeg-3.0.2

$ sudo add-apt-repository ppa:djcj/hybrid

$ sudo apt-get update

$ sudo apt-get install ffmpeg. 

Create Amazon S3 bucket and set up configuration key.

###Update Config Data

Edit configuration files to match what is in the repo.

###Copy Libraries and Source

Copy all HTML, PHP, JS (dash.all.min.js, video-js.swf, video.js, and videojs-dash.js), and AWS SDK for
PHP files to web accessible location.

Edit pathways in the above HTML and PHP files to patch physical configuration.

###Create MySQL VideoData Table

Run script.

###Port Settings

Verify ports 80 and 1935 are open.

###Client Side

For LiveStreaming use OPM on the client according to their guide on publishing to a custom server.

###Start using Site Features 


##License

This project is licensed under the MIT License - see the LICENSE.md file for details. Other libraries and applications with different licensing may be used in this project as well. 
