<?php

/**
 * file:    email.php
 * version: 1.0
 * package: Simple Phishing Toolkit (spt)
 * component:	Email template - Quick Start campaign templates (Coho Vineyard & Winery)
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
$subject = 'Your Coho Vineyard & Winery Order';

//This will set the sender's name and email address as well as reply to address
$sender_email = "security@cohovineyard.com";
$sender_friendly = "Coho Orders";
$reply_to = "no-reply@cohovineyard.com";

//Set the Content Type and transfer encoding
$content_type = "text/html; charset=utf-8";

//Set the fake link
$fake_link = "https://www.cohovineyard.com/my_account/login.jsp";

//This will populate the body of the email
$message = '<html><body>';
$message .= '
Hello $fname $lname,<br /><br />Shipping confirmation for Coho Vineyard & Winery order #<a href=@url>42CVW-4204913-8652358</a><br /><br />Your estimated delivery date is:<br />Tuesday, March 20, 2012<br /><br /><a href="$link">Track your package</a>.  Thank you for shopping with us. We thought you would like to know that we shipped your recent order. If you need to return an item from this shipment or manage other orders, please visit <a href=@url>Your Orders on CohoVineyard.com</a>.<br /><br />Shipment Details<br /><br />Spottswoode Cabernet Sauvignon (750 mL), Napa Vally, 1993 RP92 - $149.99 each (QTY x2)<br />Spottswoode Magnum (1500 mL), 1994 - $325.00 each (QTY x1)<br />Item Subtotal: $624.98<br />Shipping & Handling: - $14.40<br />Total Before Tax: - $639.38 <br />Shipment Total: $639.38<br />Paid by card on file: $639.38<br /><br />You have only been charged for the items sent in this shipment. Per our policy, you only pay for items when we ship them to you.<br /><br />Returns are easy. Visit our <a href="$link>Customer Service </a> page if you need to return an item or need any further assistance with your order.<br /><br />We hope to see you again soon!<br />Coho Vineyard & Winery<br /><br /><br /><br />Received this message in error?  Please visit our <a href=@url>Customer Service</a> page to report this occurence to us.';
$message .= '</body></html>';
?>