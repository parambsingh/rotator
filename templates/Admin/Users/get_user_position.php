<h5 class="h5"><?= $userPosition->user->name; ?> - <?= $userPosition->user->email; ?></h5>
<form action="javascript:void(0);" id="changePositionOrderForm">
    <div class="row">
        <div class="col-md-6">
            <label style="margin-top: 10px;">Position Sequence:</label>
        </div>
        <div class="col-md-6">
            <input type="number" name="position_order" placeholder="Position Sequence"
                   value="<?= $userPosition['position_order']; ?>"
                   class="form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10  not-ignore    "
                   id="newPosition"/>
            <input type="hidden" name="user_position_id" value="<?= $userPosition->id; ?>"/>
        </div>
        <div class="col-md-12 mt-4">
            <button class="btn-u btn-u-orange btn-u-md rounded pull-right cancel-btn" onclick="Custombox.modal.close();"><i
                        class="fa fa-times"></i> Cancel
            </button>
            <button type="submit" class="btn-u btn-u-blue btn-u-md rounded pull-right mr-3"><i
                        class="fa fa-exchange rotate90"></i> Update Position Sequence
            </button>
        </div>
    </div>
</form>
<script>
    $(function () {
        $('.cancel-btn').click(function (e) {
            e.preventDefault();
        });
        $('#changePositionOrderForm').validate({
            rules: {
                position_order: {
                    required: true,
                    min: 1,
                    max:<?= $max; ?>,
                }
            },
            messages: {
                position_order: {
                    required: "Please enter position sequence.",
                    min: "Position order must be greater than or equal to 1.",
                    max: "Position order must be less than or equal to <?= $max; ?>.",
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + 'admin/users/changeUserPosition',
                    data: $('#changePositionOrderForm').serialize(),
                    dataType: "JSON",
                    success: function (response) {
                        window.location.href = SITE_URL + 'admin/distributors/manage-positions?page=' + response.data.page + '&sort=UsersPositions.position_order&direction=asc';
                    }
                });
            }
        });

    });
</script>