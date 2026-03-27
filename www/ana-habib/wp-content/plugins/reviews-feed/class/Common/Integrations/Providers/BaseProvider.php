<?php

namespace SmashBalloon\Reviews\Common\Integrations\Providers;

use SmashBalloon\Reviews\Common\Exceptions\RelayResponseException;
use SmashBalloon\Reviews\Common\Integrations\SBRelay;
use SmashBalloon\Reviews\Common\Utils\AjaxUtil;
use Smashballoon\Stubs\Services\ServiceProvider;

abstract class BaseProvider extends ServiceProvider
{

    protected $name;
    protected $endpoint;
    protected $sources_endpoint;
    protected $sources_remove;
    private $relay;
    protected $uses_connect = false;
    protected $friendly_name;

    public function __construct(SBRelay $relay)
    {
        $this->relay = $relay;
        $this->endpoint = 'reviews/' . $this->name;
        $this->sources_endpoint = 'sources/' . $this->name;
        $this->sources_remove = 'source/remove';
    }

    public function register()
    {
        add_action('rest_api_init', [$this, 'registerRestEndpoint']);
        add_filter('sbr_supported_providers', [$this, 'registerProvider']);
    }

    /**
     * @throws RelayResponseException
     */
    public function getAllReviews($args = []): void
    {
        try {
            $response = $this->relay->call($this->endpoint, $args->get_params(), 'GET', true);
            wp_send_json($response);
        }catch (RelayResponseException $exception) {
            AjaxUtil::send_json_error($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @throws RelayResponseException
     */
    public function getSourcesInfo($args = []) {
        $response = $this->relay->call( $this->sources_endpoint  , $args, 'GET', true);
        if( isset( $response['data'] ) && $response['data'] ){
            return wp_json_encode( $response['data'] );
        }
        return false;
    }

    public function registerRestEndpoint()
    {
        register_rest_route(SBR_REST_DOMAIN, '/' . $this->endpoint, array(
            'methods' => 'GET',
            'callback' => [$this, 'getAllReviews'],
            'permission_callback' => '__return_true'
        ));
    }

    public function registerProvider($providers) {
        $providers[] = [
            'name' => $this->name,
            'endpoint' => get_rest_url(null, SBR_REST_DOMAIN . '/' . $this->endpoint),
            'uses_connect' => $this->uses_connect,
            'friendly_name' => $this->friendly_name
        ];

        return $providers;
    }

    /**
     * @throws RelayResponseException
     */
    public function removeSource($args = [])
    {
        $response = $this->relay->call($this->sources_remove, $args, 'POST', true);
        if (isset($response)) {
            return wp_json_encode($response);
        }
        return false;
    }
}