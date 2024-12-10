
    <tr>
        <td>
            <span aria-hidden="true" name="scan-id" style="display:none">scan.id</span>
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="mask mask-squircle h-12 w-12">
                        <img src="https://minnetonkaorchards.com/wp-content/uploads/2021/04/Bright-Red-Apple.jpg"
                            alt="Avatar Tailwind CSS Component" />
                    </div>
                </div>
                <div>
                    <div class="font-bold" name="produce">scan.produce</div>
                    <div class="text-sm opacity-50" name="scannedAt">scan.created_at</div>
                </div>
            </div>
        </td>
        <td>
            <span name="confidence">scan.confidence.2f</span>
            <br />
            <span class="badge badge-ghost badge-sm text-green-600" name="condition">scan.confidece>50 ? "Fresh":
                "Rotten"</span>
        </td>
        <td name="verifiedStore">Verfied</td>
        <th>
            <button class="btn btn-ghost btn-xs" role="link" href="">details</button>
        </th>
    </tr>