# ONM. Optical Network Manager.

Onm is a library for the management of optical network through TL1 protocol.

## Usage

```php
$nm = new onm\NetworkManager('172.16.0.2', 3337, 'admin', 'admin', 'cTag', onm\Fiberhome::class);

$devices = $nm->lstDevice()->response; // Get all OLT from network
$unregisteredOnu = $nm->lstUnregonu()->response; // Get all unregistered ONU
$allOnu = $nm->lstOnu(['OLTID' => '10.0.1.200'])->response; // Get all ONU from an OLT

// Register a ONU
$registerOnu = $nm->addOnu(['OLTID' => '10.0.1.200', 'PONID' => 'NA-NA-1-1'], 
['NAME' => 'test', 'AUTHTYPE' => 'SN', 'ONUID' => 'FHTT928B0000', 'ONUTYPE' => 'AN5506-01-A']); 

if($registerOnu->success) print('ONU registered was successfuly.');

// Get optical information of ONU or a PON
$getOpticalInfo = $nm->lstOmddm(['OLTID' => '10.0.1.200', 'PONID' => 'NA-NA-1-1',
'ONUIDTYPE' => 'MAC', 'ONUID' => 'FHTT928B0000']); 

if($getOpticalInfo->success) 
{
    print(sprintf('RxPower: %s; ', $getOpticalInfo->response['RxPower']));
    print(sprintf('Temperature: %s; ', $getOpticalInfo->response['Temperature']));
}

// Using callback
$nm->lstDevice()->success(function($responde) {
    foreach($response as $device) {
      print(sprintf('Name: %s; ', $device['DEVNAME']));
      print(sprintf('IP Address: %s; ', $device['DEVIP']));
      print(sprintf('Model: %s', $device['DT']));
      print(PHP_EOL);
    }
});

// Setting up a VLAN on the ONU
$nm->cfgLanport([
  'OLTID' => '10.0.1.200', 
  'PONID' => 'NA-NA-1-1', 
  'ONUIDTYPE' => 'SN', 
  'ONUID' => 'FHTT928B0000',
  'ONUPORT' => 'NA-NA-NA-1'
 ], [
  'PVID' => '1000', 
  'VLANMOD' => 'Tag'
])->success(function() {
  print('VLAN setting was successfuly.');
})->fail(function($err) {
  print('VLAN setting was not successfuly.'.PHP_EOL);
  print(sprintf('Error: %s', $err));
}); 
```
## Installing
```bash
composer require mnsd47/onm
```
## Supported vendors
| Vendor | Classname | Instantiation | 
|---------|------------|---------------------|
| Fiberhome | Fiberhome | `new NetworkManager($ems, $port, $user, $pass, $ctag, Fiberhome::class)` |
| Multilaser | Multilaser | `new NetworkManager($ems, $port, $user, $pass, $ctag, Multilaser::class)` | 

## UML
![Class diagram](diagram.png?raw=true)

## License
MIT License (MIT). [License File](LICENSE)
