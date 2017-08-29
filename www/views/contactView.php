<?php

class ContactView extends View {
        
    protected function displayContent() {

    	$html = '<h2>'.$this -> pageInfo['pageHeading'].'</h2>'."\n";
    	$html .= '<div class="content" id="contactContent">'."\n";


    	if(!$this -> model -> mobileDetect  && !$this -> model -> tabletDetect ) {
            /*
            If the user isn't using a mobile phone or tablet, then generating the business card images.
            */
    		$html .= '<img src="images/contact/Brad-Contact.jpg" id="contactBrad" class="businessCard">'."\n";
    		$html .= '<img src="images/contact/Ryan-Contact.jpg" id="contactRyan" class="businessCard">'."\n";
        } else {
            /*
            Iff the user is using a mobile phone or tablet, so as to speed up the page loading, and
            to not restrict bandwidth the contact details is delivered in text instead of images.
            */
        	$html .= '<ul>'."\n";
        	$html .= '<li>Brad Harley<li>'."\n";
        	$html .= '<li>b.harley@perspective.org.nz<li>'."\n";
        	$html .= '<li>P.O. Box 27234<li>'."\n";
        	$html .= '<li>Marion Square<li>'."\n";
        	$html .= '<li>Wellington<li>'."\n";
        	$html .= '<li>6141<li>'."\n";
        	$html .= '<li>0272486204<li>'."\n";       	
        	$html .= '</ul>'."\n";

        	$html .= '<ul>'."\n";
        	$html .= '<li>Ryan Harley<li>'."\n";
        	$html .= '<li>r.harley@perspective.org.nz<li>'."\n";
        	$html .= '<li>47 Sydney St<li>'."\n";
        	$html .= '<li>Takapau<li>'."\n";
        	$html .= '<li>Central Hawkes Bay<li>'."\n";
        	$html .= '<li>4203<li>'."\n";
        	$html .= '<li>0272486202<li>'."\n";       	
        	$html .= '</ul>'."\n";
        }	

    	
    	$html .= '</div>'."\n";


        return $html;        
    }
            
        
}


?>