<?php

/**
 * file:    send_emails.php
 * version: 5.0
 * package: Simple Phishing Toolkit (spt)
 * component:   Campaign management
 * copyright:   Copyright (C) 2011 The SPT Project. All rights reserved.
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
// verify session is authenticated and not hijacked
$includeContent = "../includes/is_authenticated.php";
if ( file_exists ( $includeContent ) ) {
    require_once $includeContent;
} else {
    echo "stop (auth)";
    exit;
}

// verify user is an admin
$includeContent = "../includes/is_admin.php";
if ( file_exists ( $includeContent ) ) {
    require_once $includeContent;
} else {
    echo "stop (admin)";
    exit;
}

//validate a campaign is specified
if ( ! isset ( $_POST[ "c" ] ) ) {
    echo "stop (campaign)";
    exit;
} else {
    $campaign_id = $_POST[ 'c' ];
}

//connect to database
include('../spt_config/mysql_config.php');

//ensure campaign status is set to active
$r = mysql_query ( "SELECT status FROM campaigns WHERE id = '$campaign_id'" );
while ( $ra = mysql_fetch_assoc ( $r ) ) {
    if ( $ra[ 'status' ] != 1 ) {
        echo "stop (not active)";
        exit;
    }
}

//check to see if delay counter is set to a second or more
if ( isset ( $_SESSION[ 'delay_counter' ] ) ) {
    if ( $_SESSION[ 'delay_counter' ] >= 1000 ) {
        $_SESSION[ 'delay_counter' ] = $_SESSION[ 'delay_counter' ] - 1000;
        exit;
    }
}

//get the message delay value for this campaign
$r = mysql_query ( "SELECT message_delay FROM campaigns WHERE id = '$campaign_id'" );
while ( $ra = mysql_fetch_assoc ( $r ) ) {
    $message_delay = $ra[ 'message_delay' ];
}

//set time
$time_left = 1000;

//decrement time counter any left over time from previous
if ( isset ( $_SESSION[ 'delay_counter' ] ) ) {
    $time_left = $time_left - $_SESSION[ 'delay_counter' ];
}

//determine how many messages will be sent
$number_messages_sent = 0;
while ( $time_left >= $message_delay ) {
    $number_messages_sent ++;
    $time_left = $time_left - $message_delay;
}

//get the path of spt and the template id for this campaign
$r = mysql_query ( "SELECT spt_path, template_id FROM campaigns WHERE id = '$campaign_id'" );
while ( $ra = mysql_fetch_assoc ( $r ) ) {
    $spt_path = $ra[ 'spt_path' ];
    $template_id = $ra[ 'template_id' ];
}

//get the smtp relay if its set
$r = mysql_query ( "SELECT relay_host, relay_username, relay_password FROM campaigns WHERE id = '$campaign_id'" );
while ( $ra = mysql_fetch_assoc ( $r ) ) {
    if ( strlen ( $ra[ 'relay_host' ] ) > 0 ) {
        $relay_host = $ra[ 'relay_host' ];
        if ( strlen ( $ra[ 'relay_username' ] ) > 0 ) {
            $relay_username = $ra[ 'relay_username' ];
        }
        if ( strlen ( $ra[ 'relay_password' ] ) > 0 ) {
            $relay_password = $ra[ 'relay_password' ];
        }
    }
}

//get the next specified number of email addresses 
$r = mysql_query ( "SELECT targets.fname AS fname, targets.lname AS lname, targets.email as email, targets.id as id, campaigns_responses.response_id as response_id FROM campaigns_responses JOIN targets ON targets.id = campaigns_responses.target_id WHERE campaigns_responses.campaign_id = '$campaign_id' AND campaigns_responses.sent = 0 LIMIT 0, $number_messages_sent" ) or die ( mysql_error () );

//send the emails
while ( $ra = mysql_fetch_assoc ( $r ) ) {
    //set the current email address
    $current_target_email_address = $ra[ 'email' ];
    $current_response_id = $ra[ 'response_id' ];
    $fname = $ra[ 'fname' ];
    $lname = $ra[ 'lname' ];

    //formulate link
    $link = "http://" . $spt_path . "/campaigns/response.php?r=" . $current_response_id;

    //pull in all the email variables from the specified template
    include "../templates/" . $template_id . "/email.php";

    //find and replace variables
    $message = preg_replace ( "#@fname#", $fname, $message );
    $message = preg_replace ( "#@lname#", $lname, $message );
    $message = html_entity_decode ( $message );
    $subject = preg_replace ( "#@fname#", $fname, $subject );
    $subject = preg_replace ( "#@lname#", $lname, $subject );

    //send the email
    require_once '../includes/swiftmailer/lib/swift_required.php';

    if ( isset ( $relay_host ) AND isset ( $relay_username ) AND isset ( $relay_password ) ) {
        //Create the Transport
        $transport = Swift_SmtpTransport::newInstance ( $relay_host, 25 )
                -> setUsername ( $relay_username )
                -> setPassword ( $relay_password )
        ;
    }
    if ( isset ( $relay_host ) AND ! isset ( $relay_username ) AND ! isset ( $relay_password ) ) {
        //Create the Transport
        $transport = Swift_SmtpTransport::newInstance ( $relay_host, 25 );
    }
    if ( ! isset ( $relay_host ) AND ! isset ( $relay_username ) AND ! isset ( $relay_password ) ) {
        //parse out the domain from the recipient email address
        $domain_parts = explode ( "@", $current_target_email_address );
        $domain = $domain_parts[ 1 ];

        //get MX record for the destination
        getmxrr ( $domain, $mxhosts );

        //create the transport
        $transport = Swift_SmtpTransport::newInstance ( $mxhosts[ 0 ], 25 );
    }

    //Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance ( $transport );

    //To use the ArrayLogger
    $logger = new Swift_Plugins_Loggers_ArrayLogger();
    $mailer -> registerPlugin ( new Swift_Plugins_LoggerPlugin ( $logger ) );

    //Create a message
    $message = Swift_Message::newInstance ( $subject )
            -> setFrom ( array ( $sender_email => $sender_friendly ) )
            -> setTo ( array ( $current_target_email_address => $fname . ' ' . $lname ) )
            -> setBody ( $message )
    ;

    //Send the message
    $mailer -> send ( $message, $failures );

    //store logs in database
    $mail_log = $logger -> dump ();
    mysql_query ( "UPDATE campaigns_responses SET response_log='$mail_log' WHERE response_id = '$current_response_id'" );

    //specify that message is sent
    mysql_query ( "UPDATE campaigns_responses SET sent = 1 WHERE response_id = '$current_response_id'" );
}

echo "active";
?>

