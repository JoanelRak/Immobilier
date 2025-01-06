<?php
$depots_results = [];
if (!empty($all_depots)) {
    $depots_results = $all_depots;
}
?>
<main>
    <section class="content-section">
        <table class="data-table">
            <thead>

            <tr>
                <th class="table-header">Id User</th>
                <th class="table-header">Montant</th>
                <th class="table-header">Validate</th>
            </tr>
            </thead>
            <tbody>

            <?php
            for ($i = 0; $i < count($depots_results); $i++) {
                $depot = $depots_results[$i];

                ?>
                <tr class="table-cell">
                    <td class="table-cell">><?php echo $depot['id_user'] ?></td>
                    <td class="table-cell">><?php echo $depot['montant'] ?></td>
                    <td class="table-cell">><a href="/insert/depot/<?php echo $i ?>">Validate</a></td>
                </tr>
            <?php }
            ?>
            </tbody>

        </table>
    </section>
</main>
