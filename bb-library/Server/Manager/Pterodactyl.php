<?php

class Server_Manager_Pterodactyl extends Server_Manager {

  public static function getForm() {
    return array(
      'label' => 'Pterodactyl Server Manager',
    );
  }

  public function getLoginUrl() {
    return $this->_config['panel_url'];
  }

  public function getResellerLoginUrl() {
    return "https://pterodactyl.io";
  }

  public function testConnection() {
    list($response, $responseCode) = _request("GET", "users");
    return $responseCode == 200;
  }

  private function _request($requestType, $endpoint, $bodyParams = array()) {
    $curl = curl_init();

    $header = array();
    $header[] = 'Authorization: Bearer ' . getAPIKey();
    $header[] = 'Accept: application/vnd.pterodactyl.' . getAPIVersion() . '+json';
    $header[] = 'Content-Type: application/json';

    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_URL, getBaseURL . $endpoint);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $dataRequestTypes = array(
      "POST",
      "PUT",
      "PATCH",
      "DELETE"
    );

    if(in_array($requestType, $dataRequestTypes)) {
      if($requestType == "POST") {
        curl_setopt($curl, CURLOPT_POST, 1);
      } else {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT")
      }

      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($bodyParams));
    }

    $response = curl_exec($curl);
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return array($response, $esponseCode);
  }

  private function getAPIKey() {
    return $this->_config['api_key'];
  }

  private function getAPIVersion() {
    return $this->_config['api_version'];
  }

  private function getBaseURL() {
    rtrim($this->_config['panel_url'], '/') . '/api/application/';
  }
}
