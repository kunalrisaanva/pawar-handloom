
<!-- =========================================================
     PROFILE PAGE
========================================================= -->

<section class="profile-section">

    <div class="container">

        <div class="profile-wrapper">

            <!-- =================================================
                 LEFT SIDEBAR
            ================================================== -->
            <aside class="profile-sidebar">

                <!-- Profile Card -->
                <div class="profile-card">

                    <div class="profile-avatar-wrapper">

                        <label for="profile_image" class="profile-image-label">

                            <div class="profile-avatar">

                                <?php if (!empty($user[0]->image)) : ?>

                                    <img
                                        src="<?= base_url('uploads/profile/' . $user[0]->image); ?>"
                                        id="previewImage"
                                        alt="Profile Image"
                                    >

                                <?php else : ?>

                                    <span id="avatarLetter">
                                        <?= strtoupper(substr($user[0]->name ?? 'U', 0, 1)); ?>
                                    </span>

                                    <img
                                        id="previewImage"
                                        src=""
                                        alt="Profile Preview"
                                        style="display:none;"
                                    >

                                <?php endif; ?>

                                <div class="avatar-overlay">
                                    <i class="fa fa-camera"></i>
                                    <small>Change Photo</small>
                                </div>

                            </div>

                        </label>

                        <input
                            type="file"
                            id="profile_image"
                            name="profile_image"
                            accept="image/*"
                            hidden
                        >

                    </div>

                    <h3>
                        <?= esc($user[0]->name ?? 'User'); ?>
                    </h3>

                    <p>
                        <?= esc($user[0]->email ?? ''); ?>
                    </p>

                    <span class="status">
                        <span class="status-dot"></span>
                        Active Account
                    </span>

                </div>


                <!-- Profile Navigation -->
                <div class="profile-menu">

                    <!-- Orders -->
                    <a
                        href="<?= base_url('UserOrders'); ?>"
                        class="menu-item"
                    >
                        <div class="menu-icon orders-icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>

                        <div class="menu-content">
                            <h5>My Orders</h5>

                            <small>
                                <?= $orderCount ?? 0; ?>
                                <?= (($orderCount ?? 0) == 1) ? 'Order' : 'Orders'; ?>
                            </small>
                        </div>

                        <i class="fa fa-angle-right menu-arrow"></i>
                    </a>


                    <!-- Addresses -->
                    <a
                        href="#saved-addresses"
                        class="menu-item"
                    >
                        <div class="menu-icon address-icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <div class="menu-content">
                            <h5>My Addresses</h5>

                            <small>
                                <?= $addressCount ?? count($addresses ?? []); ?>
                                / 5 Saved
                            </small>
                        </div>

                        <i class="fa fa-angle-right menu-arrow"></i>
                    </a>

                </div>

            </aside>


            <!-- =================================================
                 RIGHT CONTENT
            ================================================== -->
            <main class="profile-content">


                <!-- =================================================
                     PROFILE INFORMATION
                ================================================== -->
                <div class="content-card profile-info-card">

                    <div class="section-heading">

                        <div>
                            <span class="section-label">
                                ACCOUNT SETTINGS
                            </span>

                            <h2>
                                Personal Information
                            </h2>

                            <p>
                                Manage your personal details and contact information.
                            </p>
                        </div>

                        <div class="heading-icon">
                            <i class="fa fa-user"></i>
                        </div>

                    </div>


                    <!-- Success -->
                    <?php if (session()->getFlashdata('success')) : ?>

                        <div class="custom-alert success-alert">
                            <i class="fa fa-check-circle"></i>

                            <span>
                                <?= session()->getFlashdata('success'); ?>
                            </span>
                        </div>

                    <?php endif; ?>


                    <!-- Error -->
                    <?php if (session()->getFlashdata('error')) : ?>

                        <div class="custom-alert error-alert">
                            <i class="fa fa-exclamation-circle"></i>

                            <span>
                                <?= session()->getFlashdata('error'); ?>
                            </span>
                        </div>

                    <?php endif; ?>


                    <!-- Profile Form -->
                    <form
                        action="<?= base_url('profile/update'); ?>"
                        method="post"
                        enctype="multipart/form-data"
                    >

                        <?= csrf_field(); ?>


                        <div class="row">


                            <!-- Full Name -->
                            <div class="col-md-6">

                                <div class="form-group-modern">

                                    <label>
                                        <i class="fa fa-user"></i>
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        value="<?= old('name', $user[0]->name ?? ''); ?>"
                                        placeholder="Enter Full Name"
                                        required
                                    >

                                    <?php if (isset($validation) && $validation->hasError('name')) : ?>

                                        <small class="text-danger">
                                            <?= $validation->getError('name'); ?>
                                        </small>

                                    <?php endif; ?>

                                </div>

                            </div>


                            <!-- Email -->
                            <div class="col-md-6">

                                <div class="form-group-modern">

                                    <label>
                                        <i class="fa fa-envelope"></i>
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control readonly-input"
                                        value="<?= esc($user[0]->email ?? ''); ?>"
                                        readonly
                                    >

                                </div>

                            </div>


                            <!-- Phone -->
                            <div class="col-md-6">

                                <div class="form-group-modern">

                                    <label>
                                        <i class="fa fa-phone"></i>
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="phone"
                                        name="phone"
                                        value="<?= old('phone', $user[0]->phone ?? ''); ?>"
                                        placeholder="Phone Number"
                                        required
                                    >

                                </div>

                            </div>


                            <!-- WhatsApp -->
                            <div class="col-md-6">

                                <div class="form-group-modern">

                                    <label>
                                        <i class="fa fa-whatsapp"></i>
                                        WhatsApp Number
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="whatsapp_no"
                                        name="whatsapp_no"
                                        value="<?= old('whatsapp_no', $user[0]->whatsapp_no ?? ''); ?>"
                                        placeholder="WhatsApp Number"
                                    >

                                </div>

                            </div>


                            <!-- Same as phone -->
                            <div class="col-md-12">

                                <label class="checkbox-modern">

                                    <input
                                        type="checkbox"
                                        id="sameWhatsapp"
                                    >

                                    <span class="checkmark"></span>

                                    <span>
                                        Same as Phone Number
                                    </span>

                                </label>

                            </div>

                        </div>


                        <div class="profile-form-footer">

                            <button
                                type="submit"
                                class="save-btn"
                            >
                                <i class="fa fa-save"></i>
                                Update Profile
                            </button>

                        </div>

                    </form>

                </div>



                <!-- =================================================
                     SAVED ADDRESSES
                ================================================== -->
                <div
                    class="content-card address-card-section"
                    id="saved-addresses"
                >

                    <div class="address-header">

                        <div class="section-heading address-heading">

                            <div>

                                <span class="section-label">
                                    DELIVERY INFORMATION
                                </span>

                                <h2>
                                    Saved Addresses
                                </h2>

                                <p>
                                    Manage your delivery addresses for faster checkout.
                                </p>

                            </div>

                            <div class="heading-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>

                        </div>


                        <?php
                            $savedAddressCount = isset($addressCount)
                                ? (int)$addressCount
                                : count($addresses ?? []);
                        ?>

                        <?php if ($savedAddressCount < 5) : ?>

                            <button
                                type="button"
                                class="add-address-btn"
                                data-modal-target="addAddressModal"
                            >
                                <i class="fa fa-plus"></i>
                                Add Address
                            </button>

                        <?php endif; ?>

                    </div>


                    <!-- Address Limit -->
                    <div class="address-progress-wrapper">

                        <div class="address-progress-info">

                            <span>
                                Address Book
                            </span>

                            <strong>
                                <?= $savedAddressCount; ?> / 5
                            </strong>

                        </div>

                        <div class="address-progress">

                            <span
                                style="width: <?= min(($savedAddressCount / 5) * 100, 100); ?>%;"
                            ></span>

                        </div>

                        <?php if ($savedAddressCount >= 5) : ?>

                            <small class="limit-message">
                                <i class="fa fa-info-circle"></i>
                                You have reached the maximum limit of 5 addresses.
                            </small>

                        <?php else : ?>

                            <small>
                                You can save up to 5 delivery addresses.
                            </small>

                        <?php endif; ?>

                    </div>



                    <?php if (!empty($addresses)) : ?>

                        <div class="address-list">

                            <?php foreach ($addresses as $address) : ?>

                                <div
                                    class="address-card
                                    <?= ((int)$address->is_default === 1)
                                        ? 'default-address'
                                        : ''; ?>"
                                >

                                    <!-- Address Top -->
                                    <div class="address-top">

                                        <div class="address-title-area">

                                            <?php if ($address->address_type === 'home') : ?>

                                                <span class="address-type home-type">
                                                    <i class="fa fa-home"></i>
                                                    Home
                                                </span>

                                            <?php elseif ($address->address_type === 'office') : ?>

                                                <span class="address-type office-type">
                                                    <i class="fa fa-building"></i>
                                                    Office
                                                </span>

                                            <?php else : ?>

                                                <span class="address-type other-type">
                                                    <i class="fa fa-map-marker"></i>
                                                    Other
                                                </span>

                                            <?php endif; ?>


                                            <?php if ((int)$address->is_default === 1) : ?>

                                                <span class="default-badge">
                                                    <i class="fa fa-check"></i>
                                                    Default
                                                </span>

                                            <?php endif; ?>

                                        </div>


                                        <div class="address-action">

                                            <?php if ((int)$address->is_default !== 1) : ?>

                                                <form
                                                    action="<?= base_url('profile/address/default/' . $address->id); ?>"
                                                    method="post"
                                                    class="inline-form"
                                                >

                                                    <?= csrf_field(); ?>

                                                    <button
                                                        type="submit"
                                                        class="set-default-btn"
                                                        title="Set as default"
                                                    >
                                                        <i class="fa fa-star-o"></i>
                                                        Set Default
                                                    </button>

                                                </form>

                                            <?php endif; ?>


                                            <!-- Edit -->
                                            <a
                                                href="#"
                                                class="address-icon-btn edit-address-btn"
                                                title="Edit Address"
                                                data-address-id="<?= (int)$address->id; ?>"
                                                data-full-name="<?= esc($address->full_name ?? '', 'attr'); ?>"
                                                data-phone="<?= esc($address->phone ?? '', 'attr'); ?>"
                                                data-alternate-phone="<?= esc($address->alternate_phone ?? '', 'attr'); ?>"
                                                data-address-type="<?= esc($address->address_type ?? '', 'attr'); ?>"
                                                data-country="<?= esc($address->country ?? '', 'attr'); ?>"
                                                data-state="<?= esc($address->state ?? '', 'attr'); ?>"
                                                data-city="<?= esc($address->city ?? '', 'attr'); ?>"
                                                data-pincode="<?= esc($address->pincode ?? '', 'attr'); ?>"
                                                data-house-no="<?= esc($address->house_no ?? '', 'attr'); ?>"
                                                data-street="<?= esc($address->street ?? '', 'attr'); ?>"
                                                data-landmark="<?= esc($address->landmark ?? '', 'attr'); ?>"
                                            >
                                                <i class="fa fa-edit"></i>
                                            </a>


                                            <!-- Delete -->
                                            <form
                                                action="<?= base_url('profile/address/delete/' . $address->id); ?>"
                                                method="post"
                                                class="delete-address-form inline-form"
                                            >

                                                <?= csrf_field(); ?>

                                                <button
                                                    type="button"
                                                    class="address-icon-btn delete-address-btn"
                                                    title="Delete Address"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </div>


                                    <!-- Address Body -->
                                    <div class="address-body">

                                        <h4>
                                            <?= esc($address->full_name); ?>
                                        </h4>


                                        <!-- Phone -->
                                        <?php if (!empty($address->phone)) : ?>

                                            <div class="address-detail">

                                                <span class="detail-icon">
                                                    <i class="fa fa-phone"></i>
                                                </span>

                                                <span>
                                                    <?= esc($address->phone); ?>
                                                </span>

                                            </div>

                                        <?php endif; ?>


                                        <!-- Alternate Phone -->
                                        <?php if (!empty($address->alternate_phone)) : ?>

                                            <div class="address-detail">

                                                <span class="detail-icon">
                                                    <i class="fa fa-phone"></i>
                                                </span>

                                                <span>
                                                    <?= esc($address->alternate_phone); ?>
                                                </span>

                                            </div>

                                        <?php endif; ?>


                                        <!-- Full Address -->
                                        <div class="address-detail address-text">

                                            <span class="detail-icon">
                                                <i class="fa fa-map-marker"></i>
                                            </span>

                                            <span>

                                                <?php if (!empty($address->house_no)) : ?>
                                                    <?= esc($address->house_no); ?>,
                                                <?php endif; ?>

                                                <?php if (!empty($address->street)) : ?>
                                                    <?= esc($address->street); ?>,
                                                <?php endif; ?>

                                                <?php if (!empty($address->landmark)) : ?>
                                                    <?= esc($address->landmark); ?>,
                                                <?php endif; ?>

                                                <?php if (!empty($address->city)) : ?>
                                                    <?= esc($address->city); ?>,
                                                <?php endif; ?>

                                                <?php if (!empty($address->state)) : ?>
                                                    <?= esc($address->state); ?>
                                                <?php endif; ?>

                                                <?php if (!empty($address->pincode)) : ?>
                                                    - <?= esc($address->pincode); ?>
                                                <?php endif; ?>

                                                <?php if (!empty($address->country)) : ?>
                                                    , <?= esc($address->country); ?>
                                                <?php endif; ?>

                                            </span>

                                        </div>

                                    </div>


                                    <!-- Default Footer -->
                                    <?php if ((int)$address->is_default === 1) : ?>

                                        <div class="default-address-footer">

                                            <i class="fa fa-check-circle"></i>

                                            This address will be used as your default delivery address.

                                        </div>

                                    <?php endif; ?>

                                </div>

                            <?php endforeach; ?>

                        </div>


                    <?php else : ?>


                        <!-- No Address -->
                        <div class="no-address-box">

                            <div class="no-address-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>

                            <h3>
                                No Saved Addresses
                            </h3>

                            <p>
                                You haven't added any delivery address yet.
                                Add your first address to make checkout faster.
                            </p>

                            <button
                                type="button"
                                class="add-address-btn no-address-btn"
                                data-modal-target="addAddressModal"
                            >
                                <i class="fa fa-plus"></i>
                                Add Your First Address
                            </button>

                        </div>


                    <?php endif; ?>

                </div>

            </main>

        </div>

    </div>

</section>



<!-- =========================================================
     ADD ADDRESS MODAL
========================================================= -->

<div
    class="custom-modal"
    id="addAddressModal"
    tabindex="-1"
    aria-labelledby="addAddressModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content address-modal">


            <!-- Header -->
            <div class="modal-header">

                <div>

                    <span class="modal-label">
                        DELIVERY ADDRESS
                    </span>

                    <h4
                        class="modal-title"
                        id="addAddressModalLabel"
                    >
                        Add New Address
                    </h4>

                    <small>
                        Save your delivery address for faster checkout.
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close custom-modal-close"
                    aria-label="Close"
                ></button>

            </div>


            <!-- Form -->
            <form
                action="<?= base_url('profile/address/add'); ?>"
                method="post"
            >

                <?= csrf_field(); ?>

                <input
                    type="hidden"
                    name="address_source"
                    value="profile"
                >


                <div class="modal-body">

                    <div class="row">


                        <!-- Full Name -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Full Name
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    value="<?= old('full_name'); ?>"
                                    placeholder="Enter full name"
                                    required
                                >

                            </div>

                        </div>


                        <!-- Phone -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Phone Number
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    value="<?= old('phone'); ?>"
                                    placeholder="Enter phone number"
                                    maxlength="15"
                                    required
                                >

                            </div>

                        </div>


                        <!-- Alternate Phone -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Alternate Phone
                                </label>

                                <input
                                    type="text"
                                    name="alternate_phone"
                                    class="form-control"
                                    value="<?= old('alternate_phone'); ?>"
                                    placeholder="Alternate phone number"
                                    maxlength="15"
                                >

                            </div>

                        </div>


                        <!-- Address Type -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Address Type
                                    <span>*</span>
                                </label>

                                <select
                                    name="address_type"
                                    class="form-control"
                                    required
                                >

                                    <option value="">
                                        Select Address Type
                                    </option>

                                    <option
                                        value="home"
                                        <?= old('address_type') === 'home'
                                            ? 'selected'
                                            : ''; ?>
                                    >
                                        Home
                                    </option>

                                    <option
                                        value="office"
                                        <?= old('address_type') === 'office'
                                            ? 'selected'
                                            : ''; ?>
                                    >
                                        Office
                                    </option>

                                    <option
                                        value="other"
                                        <?= old('address_type') === 'other'
                                            ? 'selected'
                                            : ''; ?>
                                    >
                                        Other
                                    </option>

                                </select>

                            </div>

                        </div>


                        <!-- Country -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Country
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="country"
                                    class="form-control"
                                    value="<?= old('country', 'India'); ?>"
                                    placeholder="Country"
                                    required
                                >

                            </div>

                        </div>


                        <!-- State -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    State
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="state"
                                    class="form-control"
                                    value="<?= old('state'); ?>"
                                    placeholder="State"
                                    required
                                >

                            </div>

                        </div>


                        <!-- City -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    City
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="city"
                                    class="form-control"
                                    value="<?= old('city'); ?>"
                                    placeholder="City"
                                    required
                                >

                            </div>

                        </div>


                        <!-- Pincode -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Pincode
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="pincode"
                                    class="form-control"
                                    value="<?= old('pincode'); ?>"
                                    placeholder="Pincode"
                                    maxlength="10"
                                    required
                                >

                            </div>

                        </div>


                        <!-- House -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    House / Flat / Building
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="house_no"
                                    class="form-control"
                                    value="<?= old('house_no'); ?>"
                                    placeholder="House / Flat / Building"
                                    required
                                >

                            </div>

                        </div>


                        <!-- Street -->
                        <div class="col-md-6">

                            <div class="address-form-group">

                                <label>
                                    Area / Street
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    name="street"
                                    class="form-control"
                                    value="<?= old('street'); ?>"
                                    placeholder="Area / Street"
                                    required
                                >

                            </div>

                        </div>


                        <!-- Landmark -->
                        <div class="col-md-12">

                            <div class="address-form-group">

                                <label>
                                    Landmark
                                </label>

                                <input
                                    type="text"
                                    name="landmark"
                                    class="form-control"
                                    value="<?= old('landmark'); ?>"
                                    placeholder="Nearby landmark"
                                >

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Footer -->
                <div class="modal-footer">

                    <button
                        type="button"
                        class="address-cancel-btn custom-modal-close"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="address-submit-btn"
                    >
                        <i class="fa fa-save"></i>
                        Save Address
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



<!-- =========================================================
     EDIT ADDRESS MODAL
========================================================= -->
<div class="custom-modal" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content address-modal">
            <div class="modal-header">
                <div>
                    <span class="modal-label">DELIVERY ADDRESS</span>
                    <h4 class="modal-title">Edit Address</h4>
                    <small>Update your saved delivery address.</small>
                </div>
                <button type="button" class="btn-close custom-modal-close" aria-label="Close"></button>
            </div>

            <form id="editAddressForm" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6"><div class="address-form-group"><label>Full Name <span>*</span></label><input type="text" id="edit_full_name" name="full_name" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>Phone Number <span>*</span></label><input type="text" id="edit_phone" name="phone" class="form-control" maxlength="15" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>Alternate Phone</label><input type="text" id="edit_alternate_phone" name="alternate_phone" class="form-control" maxlength="15"></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>Address Type <span>*</span></label><select id="edit_address_type" name="address_type" class="form-control" required><option value="">Select Address Type</option><option value="home">Home</option><option value="office">Office</option><option value="other">Other</option></select></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>Country <span>*</span></label><input type="text" id="edit_country" name="country" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>State <span>*</span></label><input type="text" id="edit_state" name="state" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>City <span>*</span></label><input type="text" id="edit_city" name="city" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>Pincode <span>*</span></label><input type="text" id="edit_pincode" name="pincode" class="form-control" maxlength="10" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>House / Flat / Building <span>*</span></label><input type="text" id="edit_house_no" name="house_no" class="form-control" required></div></div>
                        <div class="col-md-6"><div class="address-form-group"><label>Area / Street <span>*</span></label><input type="text" id="edit_street" name="street" class="form-control" required></div></div>
                        <div class="col-md-12"><div class="address-form-group"><label>Landmark</label><input type="text" id="edit_landmark" name="landmark" class="form-control"></div></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="address-cancel-btn custom-modal-close">Cancel</button>
                    <button type="submit" class="address-submit-btn"><i class="fa fa-save"></i> Update Address</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- =========================================================
     DELETE ADDRESS MODAL
========================================================= -->

<div
    class="custom-modal"
    id="deleteAddressModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-sm">

        <div class="modal-content delete-modal">

            <div class="delete-modal-body">

                <div class="delete-icon">
                    <i class="fa fa-trash"></i>
                </div>

                <h4>
                    Delete Address?
                </h4>

                <p>
                    Are you sure you want to delete this address?
                    This action cannot be undone.
                </p>

                <div class="delete-modal-actions">

                    <button
                        type="button"
                        class="delete-cancel-btn custom-modal-close"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        class="delete-confirm-btn"
                        id="confirmDeleteAddress"
                    >
                        <i class="fa fa-trash"></i>
                        Delete
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- =========================================================
     PROFILE PAGE CSS
========================================================= -->

<style>

/* =========================================================
   MAIN PROFILE
========================================================= */

.profile-section {
    background: #f7f8fb;
    padding: 70px 0;
    min-height: 700px;
}

.profile-wrapper {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}


/* =========================================================
   SIDEBAR
========================================================= */

.profile-sidebar {
    width: 320px;
    flex: 0 0 320px;
}

.profile-card {
    background: #fff;
    padding: 35px 25px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 12px 35px rgba(0, 0, 0, .07);
    border: 1px solid #eee;
}

.profile-avatar-wrapper {
    margin-bottom: 20px;
}

.profile-image-label {
    display: inline-block;
    cursor: pointer;
}

.profile-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    margin: auto;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #c08a28, #8c6239);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 5px solid #fff;
    box-shadow: 0 8px 25px rgba(140, 98, 57, .22);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#avatarLetter {
    color: #fff;
    font-size: 52px;
    font-weight: 700;
}

.avatar-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .55);
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: .3s;
}

.profile-avatar:hover .avatar-overlay {
    opacity: 1;
}

.avatar-overlay i {
    font-size: 22px;
    margin-bottom: 5px;
}

.avatar-overlay small {
    font-size: 11px;
}

.profile-card h3 {
    margin: 5px 0 7px;
    font-size: 21px;
    font-weight: 700;
    color: #333;
}

.profile-card p {
    color: #777;
    font-size: 14px;
    margin-bottom: 18px;
    word-break: break-word;
}

.status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #eaf8ec;
    color: #24943b;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
}

.status-dot {
    width: 7px;
    height: 7px;
    background: #28a745;
    border-radius: 50%;
}


/* =========================================================
   SIDEBAR MENU
========================================================= */

.profile-menu {
    margin-top: 20px;
}

.menu-item {
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 12px;
    display: flex;
    gap: 14px;
    align-items: center;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 7px 22px rgba(0, 0, 0, .05);
    border: 1px solid #eee;
    transition: .3s;
}

.menu-item:hover {
    color: inherit;
    text-decoration: none;
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, .09);
}

.menu-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
}

.orders-icon {
    background: #f3eadf;
    color: #8c6239;
}

.address-icon {
    background: #edf5ff;
    color: #3878c9;
}

.menu-content {
    flex: 1;
}

.menu-content h5 {
    margin: 0 0 4px;
    font-size: 15px;
    font-weight: 700;
    color: #333;
}

.menu-content small {
    color: #888;
    font-size: 12px;
}

.menu-arrow {
    color: #aaa;
}


/* =========================================================
   CONTENT
========================================================= */

.profile-content {
    flex: 1;
    min-width: 0;
}

.content-card {
    background: #fff;
    border-radius: 20px;
    padding: 35px;
    margin-bottom: 30px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, .06);
    border: 1px solid #eee;
}


/* =========================================================
   SECTION HEADING
========================================================= */

.section-heading {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
}

.section-label {
    display: block;
    font-size: 11px;
    letter-spacing: 1.5px;
    color: #8c6239;
    font-weight: 700;
    margin-bottom: 5px;
}

.section-heading h2 {
    margin: 0 0 7px;
    font-size: 25px;
    font-weight: 700;
    color: #292929;
}

.section-heading p {
    margin: 0;
    color: #888;
    font-size: 13px;
}

.heading-icon {
    width: 48px;
    height: 48px;
    background: #f7efe5;
    color: #8c6239;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}


/* =========================================================
   ALERTS
========================================================= */

.custom-alert {
    padding: 13px 16px;
    border-radius: 10px;
    margin-bottom: 25px;
    display: flex;
    gap: 10px;
    align-items: center;
    font-size: 14px;
}

.success-alert {
    background: #edf9f0;
    color: #23843a;
    border: 1px solid #ccebd3;
}

.error-alert {
    background: #fff1f1;
    color: #c62828;
    border: 1px solid #f2cccc;
}


/* =========================================================
   FORM
========================================================= */

.form-group-modern {
    margin-bottom: 20px;
}

.form-group-modern label {
    display: flex;
    align-items: center;
    gap: 7px;
    font-weight: 600;
    font-size: 13px;
    color: #444;
    margin-bottom: 9px;
}

.form-group-modern label i {
    color: #8c6239;
}

.form-group-modern .form-control {
    width: 100%;
    height: 49px;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 0 15px;
    font-size: 14px;
    transition: .25s;
    background: #fff;
}

.form-group-modern .form-control:focus {
    border-color: #8c6239;
    box-shadow: 0 0 0 3px rgba(140, 98, 57, .08);
    outline: none;
}

.readonly-input {
    background: #f7f7f7 !important;
    cursor: not-allowed;
}

.profile-form-footer {
    margin-top: 10px;
    padding-top: 10px;
}

.save-btn {
    background: #8c6239;
    color: #fff;
    border: none;
    padding: 13px 28px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
}

.save-btn:hover {
    background: #c08a28;
    color: #fff;
    transform: translateY(-2px);
}


/* =========================================================
   CHECKBOX
========================================================= */

.checkbox-modern {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    cursor: pointer;
    font-size: 13px;
    color: #666;
    font-weight: 600;
    margin: 0 0 18px;
}

.checkbox-modern input {
    width: 17px;
    height: 17px;
    accent-color: #8c6239;
    cursor: pointer;
}


/* =========================================================
   ADDRESS HEADER
========================================================= */

.address-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 20px;
}

.address-heading {
    margin-bottom: 0;
}

.add-address-btn {
    background: #8c6239;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 30px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: .3s;
}

.add-address-btn:hover {
    background: #c08a28;
    color: #fff;
    transform: translateY(-2px);
}


/* =========================================================
   ADDRESS PROGRESS
========================================================= */

.address-progress-wrapper {
    margin-bottom: 25px;
    background: #fafafa;
    border: 1px solid #eee;
    padding: 14px 16px;
    border-radius: 12px;
}

.address-progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}

.address-progress-info strong {
    color: #8c6239;
}

.address-progress {
    height: 6px;
    background: #e8e8e8;
    border-radius: 10px;
    overflow: hidden;
}

.address-progress span {
    display: block;
    height: 100%;
    background: linear-gradient(90deg, #8c6239, #c08a28);
    border-radius: 10px;
    transition: .3s;
}

.address-progress-wrapper > small {
    display: block;
    margin-top: 8px;
    color: #999;
    font-size: 11px;
}

.limit-message {
    color: #c77b18 !important;
}


/* =========================================================
   ADDRESS GRID
========================================================= */

.address-list {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}


/* =========================================================
   ADDRESS CARD
========================================================= */

.address-card {
    background: #fff;
    border: 1px solid #e7e7e7;
    border-radius: 15px;
    padding: 20px;
    position: relative;
    transition: .3s;
}

.address-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, .08);
}

.address-card.default-address {
    border: 2px solid #8c6239;
    background: linear-gradient(
        180deg,
        #fffdf9 0%,
        #fff 100%
    );
}


/* =========================================================
   ADDRESS TOP
========================================================= */

.address-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 14px;
}

.address-title-area {
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
}

.address-type {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
    font-size: 14px;
}

.home-type {
    color: #8c6239;
}

.office-type {
    color: #3878c9;
}

.other-type {
    color: #777;
}

.default-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #28a745;
    color: #fff;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
}


/* =========================================================
   ADDRESS ACTION
========================================================= */

.address-action {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.inline-form {
    display: inline;
    margin: 0;
}

.set-default-btn {
    background: transparent;
    border: none;
    padding: 0;
    color: #8c6239;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.set-default-btn:hover {
    color: #c08a28;
}

.address-icon-btn {
    border: none;
    background: #f6f6f6;
    width: 31px;
    height: 31px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    text-decoration: none;
    color: #777;
    transition: .2s;
}

.address-icon-btn:hover {
    background: #f2eadf;
    color: #8c6239;
}

.delete-address-btn:hover {
    background: #fff0f0;
    color: #dc3545;
}


/* =========================================================
   ADDRESS BODY
========================================================= */

.address-card h4 {
    margin: 0 0 12px;
    font-size: 17px;
    font-weight: 700;
    color: #333;
}

.address-detail {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    color: #666;
    font-size: 13px;
    line-height: 1.65;
    margin-bottom: 8px;
}

.detail-icon {
    width: 20px;
    color: #8c6239;
    flex-shrink: 0;
    text-align: center;
}

.address-text {
    margin-top: 5px;
}

.default-address-footer {
    border-top: 1px solid #eee;
    margin-top: 15px;
    padding-top: 12px;
    font-size: 11px;
    color: #28a745;
}

.default-address-footer i {
    margin-right: 4px;
}


/* =========================================================
   NO ADDRESS
========================================================= */

.no-address-box {
    text-align: center;
    padding: 50px 25px;
    border: 1px dashed #d8d8d8;
    border-radius: 15px;
    background: #fafafa;
}

.no-address-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto 17px;
    border-radius: 50%;
    background: #f3eadf;
    color: #8c6239;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.no-address-box h3 {
    margin-bottom: 8px;
    font-size: 21px;
}

.no-address-box p {
    max-width: 480px;
    margin: 0 auto 22px;
    color: #888;
    line-height: 1.7;
    font-size: 13px;
}

.no-address-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
}


/* =========================================================
   ADD ADDRESS MODAL
========================================================= */

.address-modal {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(0, 0, 0, .20);
}

.address-modal .modal-header {
    padding: 25px 30px;
    background: #fff;
    border-bottom: 1px solid #eee;
}

.modal-label {
    display: block;
    color: #8c6239;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 5px;
}

.address-modal .modal-title {
    margin: 0 0 4px;
    color: #333;
    font-size: 23px;
    font-weight: 700;
}

.address-modal .modal-header small {
    color: #888;
    font-size: 12px;
}

.address-modal .modal-body {
    padding: 30px;
    max-height: 65vh;
    overflow-y: auto;
}

.address-form-group {
    margin-bottom: 18px;
}

.address-form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #444;
    margin-bottom: 8px;
}

.address-form-group label span {
    color: #dc3545;
}

.address-form-group .form-control,
.address-form-group select {
    width: 100%;
    height: 47px;
    border: 1px solid #ddd;
    border-radius: 9px;
    padding: 0 13px;
    font-size: 13px;
    background: #fff;
}

.address-form-group .form-control:focus,
.address-form-group select:focus {
    border-color: #8c6239;
    box-shadow: 0 0 0 3px rgba(140, 98, 57, .08);
    outline: none;
}

.address-modal .modal-footer {
    padding: 18px 30px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.address-cancel-btn,
.address-submit-btn {
    border: none;
    padding: 11px 22px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
}

.address-cancel-btn {
    background: #f3f3f3;
    color: #555;
}

.address-cancel-btn:hover {
    background: #e5e5e5;
}

.address-submit-btn {
    background: #8c6239;
    color: #fff;
}

.address-submit-btn:hover {
    background: #c08a28;
    color: #fff;
    transform: translateY(-2px);
}


/* =========================================================
   DELETE MODAL
========================================================= */

.delete-modal {
    border: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .20);
}

.delete-modal-body {
    text-align: center;
    padding: 35px 28px 30px;
}

.delete-icon {
    width: 65px;
    height: 65px;
    margin: 0 auto 18px;
    border-radius: 50%;
    background: #fff1f1;
    color: #dc3545;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.delete-modal-body h4 {
    margin: 0 0 10px;
    color: #333;
    font-size: 21px;
    font-weight: 700;
}

.delete-modal-body p {
    margin: 0 auto 25px;
    color: #777;
    font-size: 13px;
    line-height: 1.6;
    max-width: 300px;
}

.delete-modal-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.delete-cancel-btn,
.delete-confirm-btn {
    border: none;
    padding: 10px 22px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
}

.delete-cancel-btn {
    background: #f1f1f1;
    color: #555;
}

.delete-cancel-btn:hover {
    background: #e5e5e5;
}

.delete-confirm-btn {
    background: #dc3545;
    color: #fff;
}

.delete-confirm-btn:hover {
    background: #bb2d3b;
    transform: translateY(-2px);
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991px) {

    .profile-wrapper {
        flex-direction: column;
    }

    .profile-sidebar {
        width: 100%;
        flex: auto;
    }

    .profile-card {
        max-width: 500px;
        margin: auto;
    }

    .profile-menu {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .menu-item {
        margin-bottom: 0;
    }

    .address-list {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 767px) {

    .profile-section {
        padding: 40px 0;
    }

    .content-card {
        padding: 25px 20px;
    }

    .profile-menu {
        grid-template-columns: 1fr;
    }

    .address-header {
        flex-direction: column;
        align-items: stretch;
    }

    .add-address-btn {
        width: 100%;
        justify-content: center;
    }

    .address-top {
        flex-direction: column;
    }

    .address-action {
        justify-content: flex-start;
    }

    .section-heading h2 {
        font-size: 21px;
    }

}


@media (max-width: 575px) {

    .address-modal .modal-header,
    .address-modal .modal-body,
    .address-modal .modal-footer {
        padding: 20px;
    }

    .address-modal .modal-title {
        font-size: 20px;
    }

    .address-modal .modal-footer {
        flex-direction: column;
    }

    .address-cancel-btn,
    .address-submit-btn {
        width: 100%;
    }

    .delete-modal-actions {
        flex-direction: column;
    }

    .delete-cancel-btn,
    .delete-confirm-btn {
        width: 100%;
    }

}

</style>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->
<style>
/* =========================================================
   STANDALONE MODAL FIX
   Works even when Bootstrap JS is not loaded.
========================================================= */
.custom-modal {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(15, 23, 42, .62);
    overflow-y: auto;
}

.custom-modal.show {
    display: flex;
}

.custom-modal .modal-dialog {
    width: 100%;
    max-width: 800px;
    margin: 20px auto;
}

.custom-modal .modal-content {
    width: 100%;
    max-height: calc(100vh - 40px);
    display: flex;
    flex-direction: column;
}

.custom-modal .modal-body {
    overflow-y: auto;
}

body.address-modal-open {
    overflow: hidden;
}

.custom-modal .custom-modal-close {
    cursor: pointer;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       COMMON MODAL HELPERS
    ===================================================== */
    function openModal(modal) {
        if (!modal) return;
        modal.classList.add("show");
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("address-modal-open");
    }

    function closeModal(modal) {
        if (!modal) return;
        modal.classList.remove("show");
        modal.setAttribute("aria-hidden", "true");
        if (!document.querySelector(".custom-modal.show")) {
            document.body.classList.remove("address-modal-open");
        }
    }

    /* =====================================================
       PROFILE IMAGE PREVIEW
    ===================================================== */
    const profileImageInput = document.getElementById("profile_image");
    const previewImage = document.getElementById("previewImage");
    const avatarLetter = document.getElementById("avatarLetter");

    if (profileImageInput && previewImage) {
        profileImageInput.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith("image/")) {
                alert("Please select a valid image.");
                this.value = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                previewImage.src = event.target.result;
                previewImage.style.display = "block";
                if (avatarLetter) avatarLetter.style.display = "none";
            };
            reader.readAsDataURL(file);
        });
    }

    /* =====================================================
       SAME PHONE -> WHATSAPP
    ===================================================== */
    const phone = document.getElementById("phone");
    const whatsapp = document.getElementById("whatsapp_no");
    const sameWhatsapp = document.getElementById("sameWhatsapp");

    if (phone && whatsapp && sameWhatsapp) {
        sameWhatsapp.addEventListener("change", function () {
            if (this.checked) {
                whatsapp.value = phone.value;
                whatsapp.readOnly = true;
                whatsapp.style.background = "#f7f7f7";
            } else {
                whatsapp.readOnly = false;
                whatsapp.style.background = "#fff";
            }
        });

        phone.addEventListener("input", function () {
            if (sameWhatsapp.checked) whatsapp.value = this.value;
        });
    }

    /* =====================================================
       ADD ADDRESS MODAL
       Bootstrap JS ki dependency hata di gayi hai.
    ===================================================== */
    const addModal = document.getElementById("addAddressModal");

    document.querySelectorAll('[data-modal-target="addAddressModal"]').forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            openModal(addModal);
        });
    });

    /* =====================================================
       EDIT ADDRESS MODAL
    ===================================================== */
    const editModal = document.getElementById("editAddressModal");
    const editForm = document.getElementById("editAddressForm");

    document.querySelectorAll(".edit-address-btn").forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            if (!editModal || !editForm) return;

            const id = this.dataset.addressId;
            editForm.action = "<?= base_url('profile/address/update'); ?>/" + id;

            document.getElementById("edit_full_name").value = this.dataset.fullName || "";
            document.getElementById("edit_phone").value = this.dataset.phone || "";
            document.getElementById("edit_alternate_phone").value = this.dataset.alternatePhone || "";
            document.getElementById("edit_address_type").value = this.dataset.addressType || "";
            document.getElementById("edit_country").value = this.dataset.country || "India";
            document.getElementById("edit_state").value = this.dataset.state || "";
            document.getElementById("edit_city").value = this.dataset.city || "";
            document.getElementById("edit_pincode").value = this.dataset.pincode || "";
            document.getElementById("edit_house_no").value = this.dataset.houseNo || "";
            document.getElementById("edit_street").value = this.dataset.street || "";
            document.getElementById("edit_landmark").value = this.dataset.landmark || "";

            openModal(editModal);
        });
    });

    /* =====================================================
       DELETE ADDRESS MODAL
    ===================================================== */
    const deleteModal = document.getElementById("deleteAddressModal");
    const confirmDeleteButton = document.getElementById("confirmDeleteAddress");
    let deleteForm = null;

    document.querySelectorAll(".delete-address-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            deleteForm = this.closest(".delete-address-form");
            openModal(deleteModal);
        });
    });

    if (confirmDeleteButton) {
        confirmDeleteButton.addEventListener("click", function () {
            if (!deleteForm) return;

            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Deleting...';
            deleteForm.submit();
        });
    }

    /* =====================================================
       CLOSE ALL CUSTOM MODALS
    ===================================================== */
    document.querySelectorAll(".custom-modal-close").forEach(function (button) {
        button.addEventListener("click", function () {
            const modal = this.closest(".custom-modal");
            closeModal(modal);

            if (modal && modal.id === "deleteAddressModal" && confirmDeleteButton) {
                deleteForm = null;
                confirmDeleteButton.disabled = false;
                confirmDeleteButton.innerHTML = '<i class="fa fa-trash"></i> Delete';
            }
        });
    });

    /* Click outside modal content to close */
    document.querySelectorAll(".custom-modal").forEach(function (modal) {
        modal.addEventListener("click", function (event) {
            if (event.target === modal) closeModal(modal);
        });
    });

    /* ESC key */
    document.addEventListener("keydown", function (event) {
        if (event.key !== "Escape") return;
        const openedModal = document.querySelector(".custom-modal.show");
        if (openedModal) closeModal(openedModal);
    });

    /* =====================================================
       SMOOTH SCROLL TO ADDRESS
    ===================================================== */
    document.querySelectorAll('a[href="#saved-addresses"]').forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const target = document.getElementById("saved-addresses");
            if (target) {
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });
});
</script>

