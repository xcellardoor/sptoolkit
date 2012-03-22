<?php

/**
 * file:    email.php
 * version: 3.0
 * package: Simple Phishing Toolkit (spt)
 * component:	Email template - Quick Start campaign templates (Helpdesk support portal)
 * copyright:	Copyright (C) 2011 The SPT Project. All rights reserved.
 * license: GNU/GPL, see license.htm.
 * 
 * This file is part of the Simple Phishing Toolkit (spt).
 * 
 * spt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, under version 3 of the License.
 *
 * spt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with spt.  If not, see <http://www.gnu.org/licenses/>.
 * */

//this is the email template

//populate the variables below with what you want the email to look like
//the variable @link will be generated by the application, just place the
//variable @link somewhere in the email.

//You can also use @fname (first name), @lname (last name) and @url (phishing url).
$subject = 'Helpdesk Support Portal Announcement';

//This will set the sender's name and email address as well as reply to address
$sender_email = "helpdesk@contoso.com";
$sender_friendly = "Helpdesk";
$reply_to = "no-reply@contoso.com";

//Set the Content Type and transfer encoding
$content_type = "text/html; charset=utf-8";

//Set the fake link
$fake_link = "http://helpdesk.contoso.com";

//This will populate the body of the email
$message = '<html><body>';
$message .= 'Great news!<br /><br />You can now login to the Helpdesk Support Portal to quickly and easily report any problems you are having with your computer, printer or mobile device.  You can also get the latest information and news about system updates and service outages.<br /><br />Please visit the new <a href=@url>Helpdesk Support Portal</a> to report any issues, request help or check the network status.<br /><br />Thank you,<br />Helpdesk';
$message .= '</body></html>';
?>