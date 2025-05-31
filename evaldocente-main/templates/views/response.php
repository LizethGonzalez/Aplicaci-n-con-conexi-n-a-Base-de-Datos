<div class="text-center">
    <div class="card shadow">
        <?php
        $alertClass = $response->success ? 'alert-success' : 'alert-danger';
        ?>
        <div class="alert <?= $alertClass ?>" role="alert">
            <?= htmlspecialchars($response->message) ?>
            <ul style="list-style-type: none;">
                <li>
                    <a href="/home/index">home</a> &nbsp;&nbsp;
                    <a href="/survey/add">encuesta</a>
                    <a href="/survey/graph">ver gráfico</a>
                </li>
            </ul>
        </div>
    </div>
</div>
