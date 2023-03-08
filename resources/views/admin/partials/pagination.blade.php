<div class="row mt-4">
    <div class="col-md-4">
        <form method="get" class="m-2">
            <span>Row per page</span>
            <select name="page_limit" class="form-control form-control-sm d-inline"
                @if (empty($from)) onchange="this.form.submit()" @endif style="width: auto;">
                <option value="10" <?php echo $page_limit == '10' ? 'selected="selected"' : ''; ?>>
                    10
                </option>
                <option value="25" <?php echo $page_limit == '25' ? 'selected="selected"' : ''; ?>>
                    25
                </option>
                <option value="50" <?php echo $page_limit == '50' ? 'selected="selected"' : ''; ?>>
                    50
                </option>
                <option value="100" <?php echo $page_limit == '100' ? 'selected="selected"' : ''; ?>>
                    100
                </option>
            </select>
        </form>
    </div>
    <div class="col-md-8">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                {{ $buyers->links() }}
            </ul>
        </nav>
    </div>
</div>
