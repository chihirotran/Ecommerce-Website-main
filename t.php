<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal" name="category" method="post">
            <div class="form-group">
                <label class="col-md-2 control-label">Category</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" value={$row['cat_title']}" name="category" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">&nbsp;</label>
                <div class="col-md-10">

                    <button type="submit" class="btn btn-custom waves-effect waves-light btn-md" name="submit">
                        Update
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>