<?php
require_once '../secure.php';
if (!Helper::can('owner') && !Helper::can('admin')) {
    header('Location: 404');
    exit();
}

if (isset($_POST['user_ids'])) {
    $balance = new BalanceMap();
    $user_ids = $_POST['user_ids'];
    $addCounts = $_POST['addCounts'];
    $reduceCounts = $_POST['reduceCounts'];
    $subject_id = $_POST['subject_id'];
    try {
        $balance->db->beginTransaction();

        for ($i = 0; $i < count($user_ids); $i++) {
            $user_id = $user_ids[$i];
            $addCount = $addCounts[$user_id] == '' ? 0 : $addCounts[$user_id];
            $reduceCount = $reduceCounts[$user_id] == '' ? 0 : $reduceCounts[$user_id] * -1;
            $difference = $addCount + $reduceCount;

            if ($balance->findByUserIdAndSubjectId($user_id, $subject_id)) {
                $balance->update($user_id, $subject_id, $difference);
            } else {
                $balance->insert($user_id, $subject_id, $difference);
            }
        }
        $balance->db->commit();
    } catch (Exception $e) {
        $balance->db->rollBack();
        var_dump($e->getMessage());
        header('Location: ../select-balance?q=err');
        exit();
    }
    header('Location: ../select-balance?q=ok');
    exit();
}
