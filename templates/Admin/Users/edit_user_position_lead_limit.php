<h5 class="h5"><?= $userPosition->user->name; ?> - <?= $userPosition->user->email; ?></h5>
<form action="javascript:void(0);" id="changeLimitOrderForm">
    <div class="row">
        <div class="col-md-6">
            <label style="margin-top: 10px;">Max Lead Limit:</label>
        </div>
        <div class="col-md-6">
            <input type="number" name="lead_limit" placeholder="Position Order"
                   value="<?= $userPosition['lead_limit']; ?>"
                   class="form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10  not-ignore    "
                   id="newPosition"/>
            <input type="hidden" name="user_position_id" value="<?= $userPosition->id; ?>"/>
        </div>
        <div class="col-md-12 mt-4">
            <button class="btn-u btn-u-orange btn-u-md rounded pull-right" onclick="Custombox.modal.close();"><i
                        class="fa fa-times"></i> Cancel
            </button>
            <button type="submit" class="btn-u btn-u-blue btn-u-md rounded pull-right mr-3"><i
                        class="fa fa-pencil"></i> Update Lead Limit
            </button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $('#changeLimitOrderForm').validate({
            rules: {
                position_order: {
                    required: true,
                }
            },
            messages: {
                position_order: {
                    required: "Please enter max lead limit.",
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + 'admin/users/changeUserPositionLeadLimit',
                    data: $('#changeLimitOrderForm').serialize(),
                    dataType: "JSON",
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    });
</script>