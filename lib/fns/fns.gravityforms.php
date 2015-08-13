<?php
/**
 * Gravity Wiz // Gravity Forms // Require Unique Values Between Fields
 *
 * Allows you to require two or more fields on the same form to be different from each other. For example, if you are
 * collecting a personal phone number and an emergency contact phone number, this functionality can be used to ensure
 * that the same number is not used for both fields.
 *
 * @version	  1.0
 * @author    David Smith <david@gravitywiz.com>
 * @license   GPL-2.0+
 * @link      http://gravitywiz.com/gravity-forms-require-unique-values-for-different-fields/
 * @copyright 2015 Gravity Wiz
 */
class GW_Require_Unique_Values {

    public function __construct( $args = array() ) {

        // set our default arguments, parse against the provided arguments, and store for use throughout the class
        $this->_args = wp_parse_args( $args, array(
            'form_id'   => false,
            'field_ids' => false,
	        'validation_message' => __( 'Please enter a unique value.' )
        ) );

	    $this->_args['master_field_id'] = array_shift( $this->_args['field_ids'] );

        // do version check in the init to make sure if GF is going to be loaded, it is already loaded
        add_action( 'init', array( $this, 'init' ) );

    }

    public function init() {

        // make sure we're running the required minimum version of Gravity Forms
        if( ! property_exists( 'GFCommon', 'version' ) || ! version_compare( GFCommon::$version, '1.9', '>=' ) ) {
            return;
        }

		add_filter( 'gform_field_validation', array( $this, 'validate' ), 10, 4 );

    }

	public function validate( $result, $value, $form, $field ) {

		if( ! $this->is_applicable_field( $field ) ) {
			return $result;
		}

		if( ! is_array( $value ) ) {
			$value = array( $value );
		}

		$master_value = $this->get_master_value( $form );
		$value_diff   = array_diff( $master_value, $value );
		$is_unique    = ! empty( $value_diff );

		if ( $result['is_valid'] && ! empty( $value ) && ! $is_unique ) {
			$result['is_valid'] = false;
			$result['message']  = $this->_args['validation_message'];
		}

		return $result;
	}

	public function get_master_value( $form ) {

		$master_field_id = $this->_args['master_field_id'];
		$master_field = GFFormsModel::get_field( $form, $master_field_id );

		if( $master_field->inputs ) {
			foreach( $master_field->inputs as $input ) {
				$master_value[] = rgpost( sprintf( 'input_%s', str_replace( '.', '_', $input['id'] ) ) );
			}
		} else {
			$master_value[] = rgpost( sprintf( 'input_%s', $master_field_id ) );
		}

		return $master_value;
	}

	public function is_applicable_field( $field ) {

		if( ! $this->_args['field_ids']  ) {
			return false;
		} else if( ! in_array( $field->id, $this->_args['field_ids'] ) ) {
			return false;
		}

		return true;
	}

}

# Configuration

new GW_Require_Unique_Values( array(
	'form_id' => 1,
	'field_ids' => array( 9, 10 ),
	'validation_message' => '<em>Your Email</em> and <em>Spouse/Fiancé Email</em> must be different emails.',
) );