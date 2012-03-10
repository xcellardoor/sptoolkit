<?php

/**
 * file:    email.php
 * version: 1.0
 * package: Simple Phishing Toolkit (spt)
 * component:	Email template - Quick Start campaign templates (DGXT Virus)
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
$subject = 'DGXT Virus has been detected in your mailbox!';

//This will set the sender's name and email address as well as reply to address
$sender_email = "seucurity@microsoft.com";
$sender_friendly = "Email Administrator";
$reply_to = "no-reply@microsoft.com";

//Set the Content Type and transfer encoding
$content_type = "text/html; charset=utf-8";

//Set the fake link
$fake_link = "https://login.live.com/login.srf?cbcxt=out&vv=910&wa=wsignin1.0&wtrealm=urn:federation:MicrosoftOnline";

//This will populate the body of the email
$message = '<html><body>';
$message .= 'Our Webmail automated systems scan shows that your mailbox is infected by a suspicious DGXT Virus.  The DGXT Virus is causing conflict between some of our Webmail users.  To stop this action you will have to cick the link below, and login to remove and revalidate your mailbox.<br /><br />Click or copy @link to remove the DGXT Virus threat from your mailbox.<br/ ><br />Note that none of your files will be removed or lost during this operation.<br/ ><br />Thank you,<br />IT Services';
$message .= '</body></html>';
?>