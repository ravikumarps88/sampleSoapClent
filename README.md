sample-soapclient-ravikumar
=========
Creates a SOAP Client for loading weather

Uses BeSimpleBundle for soap client call creation

BeSimpleBundle installed 

Edit the composer.json and add the following lines
  "besimple/soap":   "0.3.*@dev",
      "ass/xmlsecurity": "dev-master"
Edit the "app/AppKernel.php" and add the following lines
  public function registerBundles()
  {
          return array(
          // ...
      new BeSimple\SoapBundle\BeSimpleSoapBundle(),
      // ...
      );
  }
Run the composer update command in terminal

Created a form with fields country name and city name 

Created a service for soap api call with url as argument

Service class has function with parameters country and city and it will return weather array
