<?php
/**
 * ordersRefundedJsonArgs.php
 *
 * @since      1.0.0
 * @package    ${NAMESPACE}
 * @author     alfiopiccione <alfio.piccione@gmail.com>
 * @copyright  Copyright (c) 2018, alfiopiccione
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2
 *
 * Copyright (C) 2018 alfiopiccione <alfio.piccione@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (! isset($orderType) &&
    ! isset($customerID) &&
    empty($orderData) &&
    empty($itemsRefundedData) &&
    empty($itemsData) &&
    empty($invoiceMeta) &&
    empty($billingParentData)
) {
    return (object)array();
}

// Initialized data array
$data = array(
    'order_type'       => $orderType,
    'id'               => $orderData['id'],
    'parent_id'        => $orderData['parent_id'],
    'status'           => $orderData['status'],
    'currency'         => $orderData['currency'],
    'date_created'     => $orderData['date_created'],
    'date_modified'    => $orderData['date_modified'],
    'discount_total'   => $orderData['discount_total'],
    'discount_tax'     => $orderData['discount_tax'],
    'customer_id'      => $customerID,
    'billing'          => $billingParentData,
    'tax_code'         => $invoiceMeta['tax_code'],
    'vat_number'       => $invoiceMeta['vat_number'],
    'invoice_type'     => $invoiceMeta['invoice_type'],
    'sdi_type'         => $invoiceMeta['sdi_type'],
    'choice_type'      => $invoiceMeta['choice_type'],
    'shipping_total'   => $orderData['shipping_total'],
    'shipping_tax'     => $orderData['shipping_tax'],
    'cart_tax'         => $orderData['cart_tax'],
    'total'            => $orderData['total'],
    'total_tax'        => $orderData['total_tax'],
    'amount'           => $orderData['amount'],
    'reason'           => $orderData['reason'],
    'refunded_by'      => $orderData['refunded_by'],
    'refunded_payment' => $orderData['refunded_payment'],
    'items'            => $itemsRefundedData,
);

if (! empty($itemsRefundedDataTax)) {
    $data['items_tax'] = $itemsRefundedDataTax;
}

if (isset($invoiceNumber) && '' !== $invoiceNumber) {
    $data['invoice_number'] = $invoiceNumber;
}

if (isset($invoiceSent) && '' !== $invoiceSent) {
    $data['invoice_sent'] = $invoiceSent;
}

if (! empty($refundedData)) {
    $data['refunded'] = $refundedData;
}

if (! empty($refundedItem)) {
    $data['items_refunded'] = $refundedItem;
}

if (! empty($currentRefund)) {
    $data['current_refund_items'] = $currentRefund;
}

// Sanitize
$args = array(
    'order_type'       => FILTER_SANITIZE_STRING,
    'id'               => FILTER_VALIDATE_INT,
    'parent_id'        => FILTER_VALIDATE_INT,
    'status'           => FILTER_SANITIZE_STRING,
    'currency'         => FILTER_SANITIZE_STRING,
    'date_created'     => array(
        'data'          => FILTER_SANITIZE_STRING,
        'timezone_type' => FILTER_VALIDATE_INT,
        'timezone'      => FILTER_SANITIZE_STRING,
    ),
    'date_modified'    => array(
        'data'          => FILTER_SANITIZE_STRING,
        'timezone_type' => FILTER_VALIDATE_INT,
        'timezone'      => FILTER_SANITIZE_STRING,
    ),
    'discount_total'   => FILTER_SANITIZE_STRING,
    'discount_tax'     => FILTER_SANITIZE_STRING,
    'customer_id'      => FILTER_VALIDATE_INT,
    'billing'          => array(
        'filter' => array(FILTER_SANITIZE_STRING),
        'flags'  => FILTER_FORCE_ARRAY,
    ),
    'tax_code'         => FILTER_SANITIZE_STRING,
    'vat_number'       => FILTER_SANITIZE_STRING,
    'invoice_type'     => FILTER_SANITIZE_STRING,
    'sdi_type'         => FILTER_SANITIZE_STRING,
    'choice_type'      => FILTER_SANITIZE_STRING,
    'shipping_total'   => FILTER_SANITIZE_STRING,
    'shipping_tax'     => FILTER_SANITIZE_STRING,
    'cart_tax'         => FILTER_SANITIZE_STRING,
    'total'            => FILTER_SANITIZE_STRING,
    'total_tax'        => FILTER_SANITIZE_STRING,
    'amount'           => FILTER_SANITIZE_STRING,
    'reason'           => FILTER_SANITIZE_STRING,
    'refunded_by'      => FILTER_SANITIZE_STRING,
    'refunded_payment' => FILTER_SANITIZE_STRING,
    'items'            => array(
        'filter' => array(FILTER_SANITIZE_STRING),
        'flags'  => FILTER_FORCE_ARRAY,
    ),
);

if (! empty($itemsRefundedDataTax)) {
    $args['items_tax'] = array(
        'filter' => array(FILTER_SANITIZE_STRING),
        'flags'  => FILTER_FORCE_ARRAY,
    );
}

if (isset($invoiceNumber) && '' !== $invoiceNumber) {
    $args['invoice_number'] = FILTER_VALIDATE_INT;
}

if (isset($invoiceSent) && '' !== $invoiceSent) {
    $args['invoice_sent'] = FILTER_SANITIZE_STRING;
}

if (! empty($refundedData)) {
    $args['refunded'] = array(
        'filter' => array(FILTER_SANITIZE_STRING),
        'flags'  => FILTER_FORCE_ARRAY,
    );
}

if (! empty($refundedItem)) {
    $args['items_refunded'] = array(
        'filter' => array(FILTER_SANITIZE_STRING),
        'flags'  => FILTER_FORCE_ARRAY,
    );
}

if (! empty($currentRefund)) {
    $args['current_refund_items'] = array(
        'filter' => array(FILTER_SANITIZE_STRING),
        'flags'  => FILTER_FORCE_ARRAY,
    );
}

/**
 * Filter data and filter var
 *
 * @since 1.0.0
 */
$data = apply_filters('wc_el_inv-orders_refund_json_data', $data);
$args = apply_filters('wc_el_inv-orders_refund_json_args_filter_var', $args);

$data = filter_var_array($data, $args);

return (object)$data;
