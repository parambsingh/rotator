<?= $this->Html->script(['jquery-ui']); ?>
<?php $this->assign('title', __('Sign Up')) ?>

<!-- Login -->
<section class="g-bg-gray-light-v5">
    <div class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12">
                <?= $this->element('outer_logo') ?>
                <div class="u-shadow-v21 g-bg-white rounded g-py-40 g-px-30">
                    <header class="text-center mb-4">
                        <h2 class="h3 g-color-gray-light-v2"><span class="h3 g-color-primary">Sign Up</h2>
                        <?= $this->Flash->render() ?>
                    </header>

                    <?= $this->Form->create($user, ['class' => 'g-py-15', 'id'=>'registerForm']) ?>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Name:</label>
                            <?= $this->Form->control('name', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Name', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Email:</label>
                            <?= $this->Form->control('email', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Email','id' => 'Email', 'label' => false]) ?>
                        </div>

                        <div class="col-md-6  mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Password:</label>
                            <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'id'=>'password', 'placeholder' => 'Password', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6  mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Confirm
                                Password:</label>
                            <?= $this->Form->control('confirm_password', ['type' => 'password', 'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'Confirm Password', 'label' => false]) ?>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Address:</label>
                            <?= $this->Form->control('address', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'Address', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">City:</label>
                            <?= $this->Form->control('city', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15', 'placeholder' => 'City', 'label' => false]) ?>
                        </div>

                        <div class="col-md-6  g-mb-35">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">State:</label>
                            <?= $this->Form->control('state', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'State', 'label' => false]) ?>
                        </div>
                        <div class="col-md-6  g-mb-35">
                            <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Zip:</label>
                            <?= $this->Form->control('zip', ['class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3', 'placeholder' => 'Zip', 'label' => false]) ?>
                        </div>


                        <div class="col-12 align-self-center">
                            <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-13 g-pl-25">

                                <input name="i_accept" class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" type="checkbox"
                                       id="iAccept" data-role="apartment">
                                <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                                    <i class="fa" data-check-icon="&#xf00c"></i>
                                </div>
                                <a href="javascript:void(0);" id="aptTerms" data-role="apartment"
                                   class="g-font-weight-900 g-color-primary">
                                    I accept the Terms and Conditions </a>
                            </label>
                            <br/>
                            <label for="i_accept" class="error" style="display: none">Please accept terms and
                                conditions.</label>
                        </div>


                        <div class="col-md-5 mb-4">&nbsp;</div>
                        <div class="col-md-2 mb-4">
                            <?= $this->Form->button(__('Sign Up'), ['class' => 'btn btn-md btn-block u-btn-primary rounded g-py-13']); ?>

                            <a href="<?= SITE_URL; ?>sign-in"
                               style="width: 100%; text-align: center; float: left; margin-top: 8%;">Sign In</a>
                        </div>
                        <div class="col-md-5 mb-4">&nbsp;</div>
                    </div>
                    <?= $this->Form->end() ?>

                </div>

                <div class="w-100 text-center my-4" style="border: 3px solid #333333"></div>
                <small class=" w-100 text-center d-block g-font-size-default g-mr-10 g-mb-10 g-mb-0--md"> Copyright
                    &copy; <?= date('Y'); ?> <?= SITE_TITLE; ?>, All Rights Reserved.
                </small>

            </div>
        </div>
    </div>
</section>
<!-- End Login -->

<!-- End Login -->
<div id="emailAlreadyExistsModal"
     class="text-left g-color-gray-dark-v1 g-bg-white g-overflow-y-auto  g-pa-20"
     style="display: none; width: 600px; height: auto;">
    <h2 class="h2 g-mb-20 g-bg-primary p-4 g-color-white">Email Already Exists</h2>
    <div calss="modal-body" style="position: relative;">
        <h5>There is already an account linked with this email address, you can also use <a
                    href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'forgotPassword']); ?>">Forgot
                Password</a> link to reset your password.</h5>
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'forgotPassword']); ?>">
                    <button class="btn btn-primary">Yes</button>
                </a>
                <button class="btn btn-dark" onclick="Custombox.modal.close();">Cancel</button>
            </div>
        </div>
    </div>
    <div class="clear-both"></div>
</div>

<div id="termsModal"
     class="text-left g-color-gray-dark-v1 g-bg-white g-overflow-y-auto  g-pa-20"
     style="z-index:99999999; height: auto; max-width: 1000px; display: none; width: 100%;  min-width: 800px;">
    <h2 class="h2 g-mb-20 g-bg-primary p-4 g-color-white">Terms and Conditions</h2>
    <div calss="modal-body" style="position: relative;">
        <div class="row" style="height: 400px; overflow-y: auto; overflow-x: hidden">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="u-shadow-v21 g-bg-white rounded g-py-20 g-px-30">
                    <h1>Acceptable use policy</h1>
                    <p>These acceptable use policy (&quot;Acceptable Use Policy&quot;, &quot;AUP&quot;, &quot;Policy&quot;)
                        is an agreement between Apartment Network LLC (&quot;Apartment Network LLC&quot;, &quot;us&quot;,
                        &quot;we&quot; or &quot;our&quot;) and you (&quot;User&quot;, &quot;you&quot; or &quot;your&quot;).
                        This Policy sets forth the general guidelines and acceptable and prohibited uses of the <a
                                target="_blank" rel="nofollow" href="http://www.ApartmentNetwork.com">ApartmentNetwork.com</a>
                        website and any of its products or services (collectively, &quot;Website&quot; or &quot;Services&quot;).
                    </p>
                    <h2>Prohibited activities and uses</h2>
                    <p>You may not use the Services to publish content or engage in activity that is illegal under
                        applicable law, that is harmful to others, or that would subject us to liability, including,
                        without limitation, in connection with any of the following, each of which is prohibited under
                        this Policy:</p>
                    <ul>
                        <li>Distributing malware or other malicious code.</li>
                        <li>Disclosing sensitive personal information about others.</li>
                        <li>Collecting, or attempting to collect, personal information about third parties without their
                            knowledge or consent.
                        </li>
                        <li>Distributing pornography or adult related content.</li>
                        <li>Promoting or facilitating prostitution or any escort services.</li>
                        <li>Hosting, distributing or linking to child pornography or content that is harmful to
                            minors.
                        </li>
                        <li>Promoting or facilitating gambling, violence, terrorist activities or selling weapons or
                            ammunition.
                        </li>
                        <li>Engaging in the unlawful distribution of controlled substances, drug contraband or
                            prescription medications.
                        </li>
                        <li>Managing payment aggregators or facilitators such as processing payments on behalf of other
                            businesses or charities.
                        </li>
                        <li>Facilitating pyramid schemes or other models intended to seek payments from public actors.
                        </li>
                        <li>Threatening harm to persons or property or otherwise harassing behavior.</li>
                        <li>Purchasing any of the offered Services on someone else’s behalf.</li>
                        <li>Misrepresenting or fraudulently representing products or services.</li>
                        <li>Infringing the intellectual property or other proprietary rights of others.</li>
                        <li>Facilitating, aiding, or encouraging any of the above activities through our Services.</li>
                    </ul>
                    <h2>System abuse</h2>
                    <p>Any User in violation of our Services security is subject to criminal and civil liability, as
                        well as immediate account termination. Examples include, but are not limited to the
                        following:</p>
                    <ul>
                        <li>Use or distribution of tools designed for compromising security of the Services.</li>
                        <li>Intentionally or negligently transmitting files containing a computer virus or corrupted
                            data.
                        </li>
                        <li>Accessing another network without permission, including to probe or scan for vulnerabilities
                            or breach security or authentication measures.
                        </li>
                        <li>Unauthorized scanning or monitoring of data on any network or system without proper
                            authorization of the owner of the system or network.
                        </li>
                    </ul>
                    <h2>Service resources</h2>
                    <p>You may not consume excessive amounts of the Services or use the Services in any way which
                        results in performance issues or which interrupts the services for other Users. Prohibited
                        activities that contribute to excessive use, include without limitation:</p>
                    <ul>
                        <li>Deliberate attempts to overload the Services and broadcast attacks (i.e. denial of service
                            attacks).
                        </li>
                        <li>Engaging in any other activities that degrade the usability and performance of our
                            Services.
                        </li>
                    </ul>
                    <h2>No spam policy</h2>
                    <p>You may not use our Services to send spam or bulk unsolicited messages. We maintain a zero
                        tolerance policy for use of our Services in any manner associated with the transmission,
                        distribution or delivery of unsolicited bulk or unsolicited commercial e-mail, or the sending,
                        assisting, or commissioning the transmission of commercial e-mail that does not comply with the
                        U.S. CAN-SPAM Act of 2003 (&quot;SPAM&quot;).</p>
                    <p>Your products or services advertised via SPAM (i.e. Spamvertised) may not be used in conjunction
                        with our Services. This provision includes, but is not limited to, SPAM sent via fax, phone,
                        postal mail, email, instant messaging, or newsgroups.</p>
                    <p>Sending emails through our Services to purchased email lists (&quot;safe lists&quot;) will be
                        treated as SPAM. We may terminate the Service of any User who sends out SPAM with or without
                        notice.</p>
                    <h2>Defamation and objectionable content</h2>
                    <p>We value the freedom of expression and encourages Users to be respectful with the content they
                        post. We are not a publisher of User content and are not in a position to investigate the
                        veracity of individual defamation claims or to determine whether certain material, which we may
                        find objectionable, should be censored. However, we reserve the right to moderate, disable or
                        remove any content to prevent harm to others or to us or our Services, as determined in our sole
                        discretion.</p>
                    <h2>Copyrighted content</h2>
                    <p>Copyrighted material must not be published via our Services without the explicit permission of
                        the copyright owner or a person explicitly authorized to give such permission by the copyright
                        owner. Upon receipt of a claim for copyright infringement, or a notice of such violation, we
                        will immediately run full investigation and, upon confirmation, will notify the person or
                        persons responsible for publishing it and, in our sole discretion, will remove the infringing
                        material from the Services. We may terminate the Service of Users with repeated copyright
                        infringements. Further procedures may be carried out if necessary. We will assume no liability
                        to any User of the Services for the removal of any such material.</p>
                    <p>If you believe your copyright is being infringed by a person or persons using our Services,
                        please send a report of the copyright infringement to the contact details listed at the end of
                        this Policy. Your notice must include the following:</p>
                    <ul>
                        <li>Identification of the copyrighted work claimed to have been infringed, or if multiple
                            copyrighted words at a single site are covered by a single notification, a representative
                            list of such works at that site.
                        </li>
                        <li>Identification of the material that is claimed to be infringing or to be the subject of
                            infringing activity and that is to be removed or access to which is to be disabled, and
                            information reasonably sufficient to permit us to locate the material.
                        </li>
                        <li>Information reasonably sufficient to permit us to contact you, such as an address, telephone
                            number, and, if available, an e-mail address.
                        </li>
                        <li>A statement that you have a good faith belief that use of the material in the manner
                            complained of is not authorized by the copyright owner, the copyright owner's agent, or the
                            law.
                        </li>
                        <li>A statement that the information in the notification is accurate, and under penalty of
                            perjury that you are authorized to act on behalf of the owner of an exclusive right that is
                            allegedly infringed.
                        </li>
                        <li>A physical or electronic signature of a person authorized to act on behalf of the owner of
                            an exclusive right that is allegedly infringed.
                        </li>
                    </ul>
                    <h2>Security</h2>
                    <p>You take full responsibility for maintaining reasonable security precautions for your account.
                        You are responsible for protecting and updating any login account provided to you for our
                        Services. You must protect the confidentiality of your login details, and you should change your
                        password periodically.</p>
                    <h2>Enforcement</h2>
                    <p>We reserve our right to be the sole arbiter in determining the seriousness of each infringement
                        and to immediately take corrective actions, including but not limited to:</p>
                    <ul>
                        <li>Suspending or terminating your Service with or without notice upon any violation of this
                            Policy. Any violations may also result in the immediate suspension or termination of your
                            account.
                        </li>
                        <li>Disabling or removing any content which is prohibited by this Policy, including to prevent
                            harm to others or to us or our Services, as determined by us in our sole discretion.
                        </li>
                        <li>Reporting violations to law enforcement as determined by us in our sole discretion.</li>
                        <li>A failure to respond to an email from our abuse team within 2 days, or as otherwise
                            specified in the communication to you, may result in the suspension or termination of your
                            Services.
                        </li>
                    </ul>
                    <p>Suspended and terminated User accounts due to violations will not be re-activated. A backup of
                        User’s data may be requested, however, we may not be able to provide you with one and, as such,
                        you are strongly encouraged to take your own backups.</p>
                    <p>Nothing contained in this Policy shall be construed to limit our actions or remedies in any way
                        with respect to any of the prohibited activities. We reserve the right to take any and all
                        additional actions we may deem appropriate with respect to such activities, including without
                        limitation taking action to recover the costs and expenses of identifying offenders and removing
                        them from our Services, and levying cancellation charges to cover our costs. In addition, we
                        reserve at all times all rights and remedies available to us with respect to such activities at
                        law or in equity.</p>
                    <h2>Reporting violations</h2>
                    <p>If you have discovered and would like to report a violation of this Policy, please contact us
                        immediately. We will investigate the situation and provide you with full assistance.</p>
                    <h2>Changes and amendments</h2>
                    <p>We reserve the right to modify this Policy or its terms relating to the Website or Services at
                        any time, effective upon posting of an updated version of this Policy on the Website. When we
                        do, we will post a notification on the main page of our Website. Continued use of the Website
                        after any such changes shall constitute your consent to such changes.</p>
                    <h2>Acceptance of this policy</h2>
                    <p>You acknowledge that you have read this Policy and agree to all its terms and conditions. By
                        using the Website or its Services you agree to be bound by this Policy. If you do not agree to
                        abide by the terms of this Policy, you are not authorized to use or access the Website and its
                        Services.</p>
                    <h2>Contacting us</h2>
                    <p>If you would like to contact us to understand more about this Policy or wish to contact us
                        concerning any matter relating to it, you may do so via the <a target="_blank" rel="nofollow"
                                                                                       href="http://www.apartmentnetwork.com/contact">contact
                            form</a> or write a letter to PO BOX 1328 Naples, FL 34106</p>
                    <p>This document was last updated on December 5, 2019</p>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-right">
                <button class="btn btn-primary" id="acceptTerms">Accept</button>
                <button class="btn btn-dark" onclick="Custombox.modal.close();">Cancel</button>
            </div>
        </div>
    </div>
    <div class="clear-both"></div>
</div>

<script>
    $(function () {
        var role = "apartment";
        $('#iAccept, #aptTerms').click(function (e) {
            e.preventDefault();
            var newModal = new Custombox.modal({
                overlay: {
                    close: false
                },
                content: {
                    target: "#termsModal",
                    effect: "slide",
                    animateFrom: "bottom",
                    animateTo: "top",
                    positionX: "center",
                    positionY: "center",
                    speedIn: 300,
                    speedOut: 300,
                    fullscreen: false,
                    onClose: function () {
                        //
                    }
                }
            });
            newModal.open();

            role = $(this).attr('data-role');

            return false;
        });
        $('#acceptTerms').click(function (e) {
            e.preventDefault();
            $('#iAccept').prop('checked', true);

            Custombox.modal.close();
        });

    });

    $(function () {

        $('#phone').usPhoneFormat();

        $("#registerForm").validate({
            ignore: ":hidden:not(#iAccept, .not-ignore)",
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    //remote: SITE_URL + '/users/isUniqueEmail',
                    remote: {
                        url: SITE_URL + '/users/isUniqueEmail',
                        data: {
                            email: function () {
                                return $("#Email").val();
                            }
                        },
                        complete: function (resp) {
                            if (resp.responseText == "false") {
                                var newModal = new Custombox.modal({
                                    overlay: {
                                        close: false
                                    },
                                    content: {
                                        target: "#emailAlreadyExistsModal",
                                        effect: "slide",
                                        animateFrom: "bottom",
                                        animateTo: "top",
                                        positionX: "center",
                                        positionY: "center",
                                        speedIn: 300,
                                        speedOut: 300,
                                        fullscreen: false,
                                        onClose: function () {
                                            //
                                        }
                                    }
                                });
                                newModal.open();


                            }
                            return resp;
                        }

                    }
                },
                password: {
                    required: true,
                    minlength: 8,
                    pwcheck: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                },
                address: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                zip: {
                    required: true,
                    maxlength: 5
                },
                i_accept: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your name."
                },
                email: {
                    required: "Please enter email.",
                    email: "Please enter valid email.",
                    remote: "Email already exists"
                },
                password: {
                    required: "Please enter password.",
                    minlength: "Password must be greater than 8 characters",
                    pwcheck: "Password must contain atleast one capital character and one numeric."
                },
                confirm_password: {
                    required: "Please confirm password.",
                    equalTo: "Password does not match."
                },
                phone: {
                    required: "Please enter phone number."
                },
                address: {
                    required: "Please enter address."
                },
                city: {
                    required: "Please enter city name."
                },
                state: {
                    required: "Please enter state name."
                },
                zip: {
                    required: "Please enter zip.",
                    maxlength: "Zip must be less than 5 characters."
                },
                i_accept: {
                    required: "Please accept terms and conditions."
                }
            }
        });


    });

    $(document).on('ready', function () {
        // initialization of tabs
        $.HSCore.components.HSTabs.init('[role="tablist"]');

        // initialization of go to
        $.HSCore.components.HSGoTo.init('.js-go-to');

        $('.select-user-type').click(function () {
            $('.select-user-type').removeClass('active');
            $(this).addClass('active');
            $('.select-user-form').hide();
            $('#' + $(this).attr('id') + 'Form').fadeIn();
        });
    });

    $(window).on('load', function () {
        // initialization of header
        $.HSCore.components.HSHeader.init($('#js-header'));
        $.HSCore.helpers.HSHamburgers.init('.hamburger');

        // initialization of HSMegaMenu component
        $('.js-mega-menu').HSMegaMenu({
            event: 'hover',
            pageContainer: $('.container'),
            breakpoint: 991
        });
    });

    $(window).on('resize', function () {
        setTimeout(function () {
            $.HSCore.components.HSTabs.init('[role="tablist"]');
        }, 200);
    });

</script>
