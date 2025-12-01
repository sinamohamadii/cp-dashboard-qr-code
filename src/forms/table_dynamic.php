<!-- Bulk Action Bar -->
<div class="bulk-action-bar" id="bulk-action-div">
    <form id="bulk-action" action="<?php echo url('bulk_action.php'); ?>" method="POST" class="d-flex align-items-center" style="gap: 12px;">
        <select name="action" class="bulk-select">
            <option value="download" selected>Download</option>
            <option value="delete">Delete</option>
        </select>
        <input type="hidden" name="type" value="dynamic">
        <button type="submit" class="btn-apply">Apply</button>
    </form>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="qr-list-table">
        <thead>
            <tr>
                <th style="width: 40px;"><input type="checkbox" name="bulk-select" value="1"></th>
                <th>ID <i class="fas fa-sort sort-icon"></i></th>
                <th>Owner</th>
                <th>File Name <i class="fas fa-sort sort-icon"></i></th>
                <th>Unique redirect identifier</th>
                <th>URL <i class="fas fa-sort sort-icon"></i></th>
                <th>QR Code <i class="fas fa-sort sort-icon"></i></th>
                <th>Scan <i class="fas fa-sort sort-icon"></i></th>
                <th>Status <i class="fas fa-sort sort-icon"></i></th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><input type="checkbox" name="action[]" value="<?=$row['id']?>" onchange="updateBulkActionVisibility()"></td>
                <td><?php echo $row['id']; ?></td>
                <td>Admin</td>
                <td><?php echo htmlspecialchars($row['filename']); ?></td>
                <td><?php echo htmlspecialchars($row['identifier']); ?></td>
                <td><?php echo htmlspecialchars($row['link']); ?></td>
                <td>
                    <img src="<?php echo url('saved_qrcode/' . htmlspecialchars($row['qrcode'])); ?>" class="qr-thumb" alt="QR Code">
                </td>
                <td><?php echo htmlspecialchars($row['scan']); ?></td>
                <td>
                    <?php if (strtolower($row['state']) === 'enable' || strtolower($row['state']) === 'enabled'): ?>
                        <span class="status-badge enabled">Enable</span>
                    <?php else: ?>
                        <span class="status-badge disabled">Disable</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="op-buttons">
                        <a href="<?php echo url('dynamic_qrcode.php?edit=true&id=' . $row['id']); ?>" class="op-btn edit" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo url('saved_qrcode/' . htmlspecialchars($row['qrcode'])); ?>" class="op-btn download" download title="Download"><i class="fa fa-download"></i></a>
                        <a class="op-btn delete delete_btn" data-toggle="modal" data-target="#delete-modal" data-del_id="<?php echo $row["id"];?>" title="Delete"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Footer with pagination -->
<div class="qr-list-footer">
    <span class="pagination-info"><?php 
        $start = (($page - 1) * 15 + 1);
        $end = min($page * 15, $db->totalCount);
        $total = $db->totalCount;
        if ($total > 0) {
            echo "{$start}-{$end} of {$total}";
        } else {
            echo "0 results";
        }
    ?></span>
    <?php echo paginationLinks($page, $total_pages, url('dynamic_qrcodes.php')); ?>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="delete-modal" role="dialog">
    <div class="modal-dialog">
        <form action="<?php echo url('dynamic_qrcode.php'); ?>" method="POST">
            <!-- Modal content -->

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_id" id="del_id" value="">
                    <p>Are you sure you want to delete this row? Proceeding with the cancellation it will no longer be possible to recover the unique identifier and you will delete the created QR code from the server</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.Delete Confirmation Modal -->

<script>
    const deleteButtons = document.querySelectorAll('.delete_btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('del_id').value = button.getAttribute('data-del_id');

            const deleteModal = document.querySelector('#delete-modal');
            deleteModal.style.display = 'block';
        });
    });
</script>

<script>
    function updateBulkActionVisibility() {
        const checkboxes = document.querySelectorAll('input[name="action[]"]');
        const bulkActionDiv = document.getElementById('bulk-action-div');

        const selectedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

        if (selectedCheckboxes.length > 0) {
            bulkActionDiv.classList.add('show');
        } else {
            bulkActionDiv.classList.remove('show');
        }
    }

    updateBulkActionVisibility();
</script>
