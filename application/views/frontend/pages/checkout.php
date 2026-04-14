<?php $this->load->view('frontend/partials/header'); ?>
<?php
$selected_address_id = $selected_address['id'] ?? '';
$selected_state = $selected_address['state'] ?? ($customer['state'] ?? 'Other');
$customer_name = trim(($customer['firstname'] ?? '') . ' ' . ($customer['lastname'] ?? ''));
?>

<div
    class="checkout-page"
    data-subtotal="<?php echo (float) ($summary['subtotal'] ?? 0); ?>"
    data-shipping="<?php echo (float) ($summary['shipping'] ?? 0); ?>"
>
    <div class="section-heading">
        <div class="section-kicker">Checkout</div>
        <h1 class="section-title">Choose a saved address and keep repeat orders moving fast</h1>
        <p class="section-copy">Customers can save multiple delivery locations and switch between them at checkout in one click.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="surface-card p-4 checkout-address-shell">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h2 class="h4 fw-bold mb-1">Saved delivery addresses</h2>
                        <p class="text-muted mb-0">Pick an existing address or add another one for this customer account.</p>
                    </div>
                    <button class="btn btn-outline-dark" type="button" data-address-toggle>
                        <i class="bi bi-plus-circle me-2"></i>Add new address
                    </button>
                </div>

                <div class="checkout-customer-band mb-4">
                    <div>
                        <div class="small text-uppercase text-muted fw-semibold">Customer</div>
                        <div class="fw-bold"><?php echo html_escape($customer_name !== '' ? $customer_name : ($customer['email'] ?? 'Customer')); ?></div>
                    </div>
                    <div>
                        <div class="small text-uppercase text-muted fw-semibold">Email</div>
                        <div><?php echo html_escape($customer['email'] ?? ''); ?></div>
                    </div>
                    <div>
                        <div class="small text-uppercase text-muted fw-semibold">Phone</div>
                        <div><?php echo html_escape($customer['phone_no'] ?? 'Not added'); ?></div>
                    </div>
                </div>

                <div class="alert d-none checkout-alert" data-address-feedback></div>

                <form class="surface-card p-3 p-lg-4 mb-4 d-none checkout-address-form" id="saveAddressForm" action="<?php echo site_url('frontend/save_address'); ?>" method="post">
                    <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                        <div>
                            <h3 class="h5 fw-bold mb-1" data-address-form-title>Save a new address</h3>
                            <p class="text-muted mb-0" data-address-form-copy>Use simple labels like Office, Warehouse, Branch, or Home.</p>
                        </div>
                        <button class="btn btn-sm btn-link text-decoration-none" type="button" data-address-cancel>Cancel</button>
                    </div>
                    <input type="hidden" name="id" value="" data-address-id-input>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address type</label>
                            <input class="form-control" name="address_type" placeholder="Office" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Country</label>
                            <input class="form-control" name="country" value="India" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Full address</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Flat, floor, building, street, locality" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>
                            <input class="form-control" name="city" placeholder="Mumbai" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>
                            <input class="form-control" name="state" placeholder="Maharashtra" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">PIN code</label>
                            <input class="form-control" name="pincode" placeholder="400001" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary" type="submit" data-address-submit>Save address</button>
                    </div>
                </form>

                <form id="checkoutAddressSelection">
                    <input type="hidden" name="selected_address_id" id="selected_address_id" value="<?php echo html_escape($selected_address_id); ?>">
                    <div class="row g-3" id="addressList">
                        <?php if (!empty($addresses)): ?>
                            <?php foreach ($addresses as $address): ?>
                                <?php
                                $is_selected = (string) ($address['id'] ?? '') === (string) $selected_address_id;
                                $address_label = trim(($address['address'] ?? '') . ', ' . ($address['city'] ?? '') . ', ' . ($address['state'] ?? '') . ' - ' . ($address['pincode'] ?? ''));
                                $is_dummy_address = !empty($address['is_dummy']);
                                ?>
                                <div class="col-12">
                                    <label
                                        class="checkout-address-card <?php echo $is_selected ? 'is-selected' : ''; ?>"
                                        data-address-card
                                        data-address-id="<?php echo html_escape($address['id']); ?>"
                                        data-state="<?php echo html_escape($address['state'] ?? 'Other'); ?>"
                                        data-summary="<?php echo html_escape($address_label); ?>"
                                    >
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="checkout_address"
                                            value="<?php echo html_escape($address['id']); ?>"
                                            <?php echo $is_selected ? 'checked' : ''; ?>
                                        >
                                        <div class="checkout-address-card__body">
                                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                                <div>
                                                    <div class="checkout-address-card__title">
                                                        <?php echo html_escape($address['address_type'] ?? 'Saved address'); ?>
                                                    </div>
                                                    <div class="text-muted small mb-2"><?php echo html_escape($customer_name !== '' ? $customer_name : ($customer['email'] ?? 'Customer')); ?></div>
                                                    <div class="mb-1"><?php echo nl2br(html_escape($address['address'] ?? '')); ?></div>
                                                    <div class="text-muted"><?php echo html_escape(($address['city'] ?? '') . ', ' . ($address['state'] ?? '') . ' - ' . ($address['pincode'] ?? '')); ?></div>
                                                    <div class="text-muted"><?php echo html_escape($address['country'] ?? ''); ?></div>
                                                </div>
                                                <div class="d-flex flex-column align-items-md-end gap-2">
                                                    <div class="checkout-address-chip">
                                                        <i class="bi bi-geo-alt"></i>
                                                        <span><?php echo html_escape($address['address_type'] ?? 'Address'); ?></span>
                                                    </div>
                                                    <?php if (!$is_dummy_address): ?>
                                                        <div class="d-flex gap-2">
                                                            <button
                                                                class="btn btn-sm btn-outline-dark"
                                                                type="button"
                                                                data-address-edit
                                                                data-id="<?php echo html_escape($address['id']); ?>"
                                                                data-address-type="<?php echo html_escape($address['address_type'] ?? ''); ?>"
                                                                data-address="<?php echo html_escape($address['address'] ?? ''); ?>"
                                                                data-city="<?php echo html_escape($address['city'] ?? ''); ?>"
                                                                data-state="<?php echo html_escape($address['state'] ?? ''); ?>"
                                                                data-pincode="<?php echo html_escape($address['pincode'] ?? ''); ?>"
                                                                data-country="<?php echo html_escape($address['country'] ?? ''); ?>"
                                                            >
                                                                <i class="bi bi-pencil-square me-1"></i>Edit
                                                            </button>
                                                            <button
                                                                class="btn btn-sm btn-outline-danger"
                                                                type="button"
                                                                data-address-delete
                                                                data-id="<?php echo html_escape($address['id']); ?>"
                                                            >
                                                                <i class="bi bi-trash3 me-1"></i>Delete
                                                            </button>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="small text-muted">Demo preview address</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="checkout-empty-state" id="addressEmptyState">
                                    <div class="checkout-empty-state__icon"><i class="bi bi-house-add"></i></div>
                                    <h3 class="h5 fw-bold mb-2">No saved addresses yet</h3>
                                    <p class="text-muted mb-0">Add the first delivery address and it will appear here for future checkouts.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="surface-card p-4 mt-4">
                <h2 class="h5 fw-bold mb-3">Payment method</h2>
                <div class="d-grid gap-2">
                    <label class="surface-card p-3 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-credit-card me-2"></i>Card</span>
                        <input type="radio" name="pay" checked>
                    </label>
                    <label class="surface-card p-3 d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-cash-stack me-2"></i>Cash on delivery</span>
                        <input type="radio" name="pay">
                    </label>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="surface-card p-4 checkout-summary-sticky">
                <div class="checkout-summary-band mb-3">
                    <div class="small text-uppercase fw-semibold text-muted">Delivering to</div>
                    <div class="fw-bold" id="selectedAddressType"><?php echo html_escape($selected_address['address_type'] ?? 'Select an address'); ?></div>
                    <div class="text-muted small" id="selectedAddressSummary"><?php echo html_escape($selected_address ? trim(($selected_address['address'] ?? '') . ', ' . ($selected_address['city'] ?? '') . ', ' . ($selected_address['state'] ?? '') . ' - ' . ($selected_address['pincode'] ?? '')) : 'Choose a saved address to continue.'); ?></div>
                </div>

                <h2 class="h5 fw-bold">Order summary</h2>
                <div class="d-flex justify-content-between py-2">
                    <span>Items</span>
                    <strong><?php echo (int) ($summary['item_count'] ?? 0); ?></strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>Subtotal</span>
                    <strong id="checkoutSubtotal"><?php echo '&#8377;' . number_format((float) ($summary['subtotal'] ?? 0), 2); ?></strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>Shipping</span>
                    <strong id="checkoutShipping"><?php echo '&#8377;' . number_format((float) ($summary['shipping'] ?? 0), 2); ?></strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>GST</span>
                    <strong id="checkoutGst"><?php echo '&#8377;' . number_format((float) ($summary['gst'] ?? 0), 2); ?></strong>
                </div>
                <div id="intraStateTaxRows" class="<?php echo strtolower(trim($selected_state)) === 'maharashtra' ? '' : 'd-none'; ?>">
                    <div class="d-flex justify-content-between small text-muted">
                        <span>CGST (2.5%)</span>
                        <span id="checkoutCgst"><?php echo '&#8377;' . number_format((float) ($summary['cgst'] ?? 0), 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>SGST (2.5%)</span>
                        <span id="checkoutSgst"><?php echo '&#8377;' . number_format((float) ($summary['sgst'] ?? 0), 2); ?></span>
                    </div>
                </div>
                <div id="interStateTaxRows" class="<?php echo strtolower(trim($selected_state)) === 'maharashtra' ? 'd-none' : ''; ?>">
                    <div class="d-flex justify-content-between small text-muted">
                        <span>IGST (5%)</span>
                        <span id="checkoutIgst"><?php echo '&#8377;' . number_format((float) ($summary['igst'] ?? 0), 2); ?></span>
                    </div>
                </div>
                <div class="d-flex justify-content-between py-2 border-top mt-2 pt-3">
                    <span>Total</span>
                    <strong id="checkoutTotal"><?php echo '&#8377;' . number_format((float) ($summary['total'] ?? 0), 2); ?></strong>
                </div>

                <?php if (!empty($items)): ?>
                    <div class="checkout-summary-items mt-4">
                        <?php foreach ($items as $item): ?>
                            <div class="checkout-summary-item">
                                <div>
                                    <div class="fw-semibold"><?php echo html_escape($item['product_name'] ?? 'Product'); ?></div>
                                    <div class="text-muted small">Qty <?php echo (int) ($item['qty'] ?? 1); ?></div>
                                </div>
                                <div class="fw-semibold"><?php echo '&#8377;' . number_format(((float) ($item['price'] ?? 0) * (int) ($item['qty'] ?? 1)), 2); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="checkout-empty-cart mt-4">
                        <i class="bi bi-bag-x"></i>
                        <span>Your cart is empty right now.</span>
                    </div>
                <?php endif; ?>

                <!--<button class="btn btn-primary w-100 mt-4" type="button" <?php echo empty($items) ? 'disabled' : ''; ?>>
                    Place Order
                </button>-->
                <button id="placeOrderBtn" class="btn btn-primary w-100 mt-4" type="button">
                Place Order
            </button>
            </div>
        </div>
    </div>
</div>

<script>
(function ($) {
    const page = $('.checkout-page');
    const addressList = $('#addressList');
    const emptyState = $('#addressEmptyState').closest('.col-12');
    const feedback = $('[data-address-feedback]');
    const addressForm = $('#saveAddressForm');
    const addressToggle = $('[data-address-toggle]');
    const addressFormTitle = $('[data-address-form-title]');
    const addressFormCopy = $('[data-address-form-copy]');
    const addressIdInput = $('[data-address-id-input]');
    const selectedAddressIdInput = $('#selected_address_id');
    const subtotal = Number(page.data('subtotal') || 0);
    const shipping = Number(page.data('shipping') || 0);
    const createAddressUrl = <?php echo json_encode(site_url('frontend/save_address')); ?>;
    const updateAddressUrl = <?php echo json_encode(site_url('frontend/update_address')); ?>;
    const deleteAddressUrl = <?php echo json_encode(site_url('frontend/delete_address')); ?>;
    const customerDisplayName = <?php echo json_encode($customer_name !== '' ? $customer_name : ($customer['email'] ?? 'Customer')); ?>;

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR'
        }).format(amount || 0);
    }

    //function showFeedback(type, message) {
      //  feedback.removeClass('d-none alert-success alert-danger')
        //    .addClass(type === 'success' ? 'alert-success' : 'alert-danger')
          //  .text(message);
    //}


  function showFeedback(type, message) {
    clearTimeout(window.feedbackTimer);

    feedback.stop(true, true)
        .removeClass('d-none alert-success alert-danger')
        .addClass(type === 'success' ? 'alert-success' : 'alert-danger')
        .hide()
        .text(message)
        .fadeIn(200);

    window.feedbackTimer = setTimeout(function () {
        feedback.fadeOut(300, function () {
            feedback.addClass('d-none').show();
        });
    }, 1000); 
}

    function clearFeedback() {
        feedback.addClass('d-none').removeClass('alert-success alert-danger').text('');
    }

    function resetAddressForm() {
        addressForm[0].reset();
        addressIdInput.val('');
        addressForm.attr('action', createAddressUrl);
        addressFormTitle.text('Save a new address');
        addressFormCopy.text('Use simple labels like Office, Warehouse, Branch, or Home.');
        $('[data-address-submit]').text('Save address');
    }

    function openAddressForm(mode, addressData) {
        clearFeedback();

        if (mode === 'edit' && addressData) {
            addressFormTitle.text('Edit saved address');
            addressFormCopy.text('Update this address and keep it ready for future checkouts.');
            addressForm.attr('action', updateAddressUrl);
            addressIdInput.val(addressData.id || '');
            addressForm.find('[name="address_type"]').val(addressData.address_type || '');
            addressForm.find('[name="address"]').val(addressData.address || '');
            addressForm.find('[name="city"]').val(addressData.city || '');
            addressForm.find('[name="state"]').val(addressData.state || '');
            addressForm.find('[name="pincode"]').val(addressData.pincode || '');
            addressForm.find('[name="country"]').val(addressData.country || '');
            $('[data-address-submit]').text('Update address');
        } else {
            resetAddressForm();
        }

        addressForm.removeClass('d-none');
        addressForm.find('[name="address_type"]').trigger('focus');
    }

    function renderAddressCard(address, customerName) {
        const summary = [address.address, address.city, address.state + ' - ' + address.pincode]
            .filter(Boolean)
            .join(', ');

        return `
            <div class="col-12">
                <label
                    class="checkout-address-card is-selected"
                    data-address-card
                    data-address-id="${address.id}"
                    data-state="${$('<div>').text(address.state || 'Other').html()}"
                    data-summary="${$('<div>').text(summary).html()}"
                >
                    <input class="form-check-input" type="radio" name="checkout_address" value="${address.id}" checked>
                    <div class="checkout-address-card__body">
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                            <div>
                                <div class="checkout-address-card__title">${$('<div>').text(address.address_type || 'Saved address').html()}</div>
                                <div class="text-muted small mb-2">${$('<div>').text(customerName).html()}</div>
                                <div class="mb-1">${$('<div>').text(address.address || '').html().replace(/\n/g, '<br>')}</div>
                                <div class="text-muted">${$('<div>').text((address.city || '') + ', ' + (address.state || '') + ' - ' + (address.pincode || '')).html()}</div>
                                <div class="text-muted">${$('<div>').text(address.country || '').html()}</div>
                            </div>
                            <div class="d-flex flex-column align-items-md-end gap-2">
                                <div class="checkout-address-chip">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>${$('<div>').text(address.address_type || 'Address').html()}</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <button
                                        class="btn btn-sm btn-outline-dark"
                                        type="button"
                                        data-address-edit
                                        data-id="${address.id}"
                                        data-address-type="${$('<div>').text(address.address_type || '').html()}"
                                        data-address="${$('<div>').text(address.address || '').html()}"
                                        data-city="${$('<div>').text(address.city || '').html()}"
                                        data-state="${$('<div>').text(address.state || '').html()}"
                                        data-pincode="${$('<div>').text(address.pincode || '').html()}"
                                        data-country="${$('<div>').text(address.country || '').html()}"
                                    >
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </button>
                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        type="button"
                                        data-address-delete
                                        data-id="${address.id}"
                                    >
                                        <i class="bi bi-trash3 me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        `;
    }

    function updateSummaryForState(state) {
        const normalizedState = String(state || '').trim().toLowerCase();
        const gst = subtotal * 0.05;
        let cgst = 0;
        let sgst = 0;
        let igst = gst;

        if (normalizedState === 'maharashtra') {
            cgst = subtotal * 0.025;
            sgst = subtotal * 0.025;
            igst = 0;
            $('#intraStateTaxRows').removeClass('d-none');
            $('#interStateTaxRows').addClass('d-none');
        } else {
            $('#intraStateTaxRows').addClass('d-none');
            $('#interStateTaxRows').removeClass('d-none');
        }

        $('#checkoutSubtotal').text(formatCurrency(subtotal));
        $('#checkoutShipping').text(formatCurrency(shipping));
        $('#checkoutGst').text(formatCurrency(gst));
        $('#checkoutCgst').text(formatCurrency(cgst));
        $('#checkoutSgst').text(formatCurrency(sgst));
        $('#checkoutIgst').text(formatCurrency(igst));
        $('#checkoutTotal').text(formatCurrency(subtotal + shipping + gst));
    }

    function syncSelectedAddress(card) {
        if (!card || !card.length) {
            return;
        }

        const addressId = card.data('address-id');
        const addressSummary = card.data('summary');
        const addressType = card.find('.checkout-address-card__title').first().text().trim();
        const state = card.data('state');

        selectedAddressIdInput.val(addressId);
        $('[data-address-card]').removeClass('is-selected');
        card.addClass('is-selected');
        card.find('input[type="radio"]').prop('checked', true);

        $('#selectedAddressType').text(addressType || 'Selected address');
        $('#selectedAddressSummary').text(addressSummary || 'Address selected for checkout.');
        updateSummaryForState(state);
    }

    addressToggle.on('click', function () {
        if (addressForm.hasClass('d-none')) {
            openAddressForm('create');
        } else {
            addressForm.addClass('d-none');
            resetAddressForm();
            clearFeedback();
        }
    });

    $('[data-address-cancel]').on('click', function () {
        addressForm.addClass('d-none');
        resetAddressForm();
        clearFeedback();
    });

    $(document).on('change', 'input[name="checkout_address"]', function () {
        syncSelectedAddress($(this).closest('[data-address-card]'));
    });

    $(document).on('click', '[data-address-edit]', function (event) {
        event.preventDefault();
        event.stopPropagation();

        openAddressForm('edit', {
            id: $(this).data('id'),
            address_type: $(this).data('address-type'),
            address: $(this).data('address'),
            city: $(this).data('city'),
            state: $(this).data('state'),
            pincode: $(this).data('pincode'),
            country: $(this).data('country')
        });
    });

    $(document).on('click', '[data-address-delete]', function (event) {
        event.preventDefault();
        event.stopPropagation();

        const button = $(this);
        const addressId = button.data('id');

        if (!window.confirm('Delete this saved address?')) {
            return;
        }

        clearFeedback();
        button.prop('disabled', true);

        $.ajax({
            url: deleteAddressUrl,
            type: 'POST',
            data: { id: addressId },
            dataType: 'json'
        }).done(function (response) {
            if (!response || !response.status) {
                showFeedback('error', response && response.message ? response.message : 'Unable to delete address.');
                return;
            }

            const card = button.closest('.col-12');
            const wasSelected = String(selectedAddressIdInput.val()) === String(addressId);
            card.remove();

            if (!addressList.find('[data-address-card]').length) {
                addressList.html(`
                    <div class="col-12">
                        <div class="checkout-empty-state" id="addressEmptyState">
                            <div class="checkout-empty-state__icon"><i class="bi bi-house-add"></i></div>
                            <h3 class="h5 fw-bold mb-2">No saved addresses yet</h3>
                            <p class="text-muted mb-0">Add the first delivery address and it will appear here for future checkouts.</p>
                        </div>
                    </div>
                `);
                selectedAddressIdInput.val('');
                $('#selectedAddressType').text('Select an address');
                $('#selectedAddressSummary').text('Choose a saved address to continue.');
            } else if (wasSelected) {
                syncSelectedAddress(addressList.find('[data-address-card]').first());
            }

            if (String(addressIdInput.val()) === String(addressId)) {
                addressForm.addClass('d-none');
                resetAddressForm();
            }

            showFeedback('success', response.message || 'Address deleted successfully.');
        }).fail(function () {
            showFeedback('error', 'Something went wrong while deleting the address.');
        }).always(function () {
            button.prop('disabled', false);
        });
    });

    addressForm.on('submit', function (event) {
        event.preventDefault();
        clearFeedback();

        const submitButton = $('[data-address-submit]');
        const isEditMode = addressIdInput.val() !== '';
        submitButton.prop('disabled', true).text(isEditMode ? 'Updating...' : 'Saving...');

        $.ajax({
            url: addressForm.attr('action'),
            type: 'POST',
            data: addressForm.serialize(),
            dataType: 'json'
        }).done(function (response) {
            if (!response || !response.status || !response.address) {
                showFeedback('error', response && response.message ? response.message : 'Unable to save address.');
                return;
            }

            $('#addressEmptyState').closest('.col-12').remove();

            if (isEditMode) {
                const existingCard = addressList.find('[data-address-card][data-address-id="' + response.address.id + '"]').closest('.col-12');
                const isCurrentlySelected = String(selectedAddressIdInput.val()) === String(response.address.id);

                existingCard.replaceWith(renderAddressCard(response.address, customerDisplayName));

                if (isCurrentlySelected) {
                    syncSelectedAddress(addressList.find('[data-address-card][data-address-id="' + response.address.id + '"]'));
                }
            } else {
                addressList.prepend(renderAddressCard(response.address, customerDisplayName));
                syncSelectedAddress(addressList.find('[data-address-card]').first());
            }

            addressForm.addClass('d-none');
            resetAddressForm();
            showFeedback('success', response.message || 'Address saved successfully.');
        }).fail(function () {
            showFeedback('error', 'Something went wrong while saving the address.');
        }).always(function () {
            submitButton.prop('disabled', false).text(addressIdInput.val() !== '' ? 'Update address' : 'Save address');
        });
    });

    resetAddressForm();
    syncSelectedAddress($('[data-address-card].is-selected').first().length ? $('[data-address-card].is-selected').first() : $('[data-address-card]').first());
})(jQuery);
</script>


<script>
$('#placeOrderBtn').on('click', function () {

    let token = localStorage.getItem("token");

    if (!token) {
        alert("Please login first");
        return;
    }

    let address_id = $('#selected_address_id').val();

    if (!address_id) {
        alert("Please select address");
        return;
    }

    let btn = $(this);
    btn.prop('disabled', true).text('Placing Order...');

    $.ajax({
        url: "<?= site_url('Api_handler/place_order') ?>",
        type: "POST",
        data: {
            address_id: address_id
        },
        headers: {   // ✅ ADD THIS
            "Authorization": "Bearer " + token
        },
        dataType: "json",

        success: function (res) {
            if (res.status) {
                alert("Order placed successfully!");
                window.location.href = "<?= site_url('frontend') ?>";
            } else {
                alert(res.message || "Order failed");
            }
        },

        error: function () {
            alert("Something went wrong");
        },

        complete: function () {
            btn.prop('disabled', false).text('Place Order');
        }
    });
});
</script>
<?php $this->load->view('frontend/partials/footer'); ?>
