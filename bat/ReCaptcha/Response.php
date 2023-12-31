<?php


/**
 * The response returned from the service.
 */
class Response
{
    /**
     * Succes or failure.
     * @var boolean
     */
    private $success = false;

    /**
     * Error code strings.
     * @var array
     */
    private $errorCodes = array();

    /**
     * Build the response from the expected JSON returned by the service.
     *
     * @param string $json
     * @return \ReCaptcha\Response
     */
    public static function fromJson($json)
    {
        $responseData = json_decode($json, true);

        if (!$responseData) {
            return new Response(false, array('invalid-json'));
        }

        if (isset($responseData['success']) && $responseData['success'] == true) {
            return new Response(true);
        }

        if (isset($responseData['error-codes']) && is_array($responseData['error-codes'])) {
            return new Response(false, $responseData['error-codes']);
        }

        return new Response(false);
    }

    /**
     * Constructor.
     *
     * @param boolean $success
     * @param array $errorCodes
     */
    public function __construct($success, array $errorCodes = array())
    {
        $this->success = $success;
        $this->errorCodes = $errorCodes;
    }

    /**
     * Is success?
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * Get error codes.
     *
     * @return array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }
}
