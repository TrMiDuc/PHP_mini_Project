<?php
class Model {
    protected static function getConnection() {
        return require realpath(__DIR__ . '/db_connection.php');
    }

    protected static function doQuery($sql, $types = '', $params = [], $success_message = 'Operation successful.', $fail_message = 'Operation failed.') {
        $conn = self::getConnection();
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return [
                'success' => false,
                'message' => $fail_message,
                'error' => 'Prepare failed: ' . $conn->error
            ];
        }

        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }

        if (!$stmt->execute()) {
            $stmt->close();
            return [
                'success' => false,
                'message' => $fail_message,
                'error' => 'Execute failed: ' . $stmt->error
            ];
        }

        $result = $stmt->get_result();
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return [
                'success' => true,
                'message' => $success_message,
                'data' => $data
            ];
        }

        $stmt->close();
        return [
            'success' => true,
            'message' => $success_message
        ];
    }
}
