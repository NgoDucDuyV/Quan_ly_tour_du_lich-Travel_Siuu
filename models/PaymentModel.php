<?php
class PaymentModel
{
    private $conn;
    protected $table = 'booking_payments';

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách phương thức thanh toán
    public function getPaymentMethods(): array
    {
        $sql = "SELECT * FROM `payment_methods` ORDER BY `id` ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentMethodsById($payment_method_id): array
    {
        $sql = "SELECT * 
            FROM payment_methods 
            WHERE id = :id
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $payment_method_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Lấy thông tin giá theo booking_id
    public function getBookingPricesByBookingId($booking_id): array
    {
        $sql = "SELECT * FROM `booking_prices`
            WHERE booking_id = :booking_id
            ORDER BY id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // lịch sử thanh toán theo booking_id
    public function getPaymentlogsbyid($booking_id)
    {
        $sql = "SELECT 
            pl.id AS payment_id,
            pl.booking_id,
            pl.amount,
            pl.transaction_code,
            pl.payment_image,
            pl.note,
            pl.updated_by,
            pl.created_at,

            -- Phương thức thanh toán
            pm.id AS method_id,
            pm.code AS method_code,
            pm.name AS method_name,

            -- Loại thanh toán
            pt.id AS type_id,
            pt.code AS type_code,
            pt.name AS type_name,

            -- Trạng thái thanh toán
            pst.id AS status_id,
            pst.code AS status_code,
            pst.name AS status_name,
            pst.description AS status_description,
            pst.color AS status_color,

            -- USER UPDATED BY
            u.id AS user_id,
            u.fullname AS updated_by_name,
            u.email AS updated_by_email,
            u.avatar AS updated_by_avatar

        FROM payments_logs pl

        LEFT JOIN payment_methods pm 
            ON pl.payment_method_id = pm.id

        LEFT JOIN payment_type pt 
            ON pl.payment_type_id = pt.id

        LEFT JOIN payment_status_type pst 
            ON pl.payment_status_type_id = pst.id

        LEFT JOIN users u
            ON pl.updated_by = u.id

        WHERE pl.booking_id = :booking_id
        ORDER BY pl.created_at ASC;

        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertPaymentLog(
        int $booking_id,
        float $amount,
        int $payment_method_id,
        int $payment_type_id,
        int $payment_status_type_id,
        string $transaction_code,
        ?string $payment_image = null,
        ?string $note = null,
        ?int $updated_by = null
    ): bool {
        // echo "<pre>";
        // echo "DỮ LIỆU TRUYỀN VÀO insertPaymentLog:\n";
        // print_r([
        //     'booking_id'            => $booking_id,
        //     'amount'                => $amount,
        //     'payment_method_id'     => $payment_method_id,
        //     'payment_type_id'       => $payment_type_id,
        //     'payment_status_type_id' => $payment_status_type_id,
        //     'transaction_code'      => $transaction_code,
        //     'payment_image'         => $payment_image,
        //     'note'                  => $note,
        //     'updated_by'            => $updated_by,
        // ]);
        // echo "</pre>";
        // die;
        $sql = "INSERT INTO payments_logs 
        (booking_id, amount, payment_method_id, payment_type_id, payment_status_type_id, 
        transaction_code, payment_image, note, updated_by, created_at)
        VALUES 
        (:booking_id, :amount, :payment_method_id, :payment_type_id, :payment_status_type_id,
        :transaction_code, :payment_image, :note, :updated_by, NOW())";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':booking_id'            => $booking_id,
            ':amount'                => $amount,
            ':payment_method_id'     => $payment_method_id,
            ':payment_type_id'       => $payment_type_id,
            ':payment_status_type_id' => $payment_status_type_id,
            ':transaction_code'      => $transaction_code,
            ':payment_image'         => $payment_image,
            ':note'                  => $note,
            ':updated_by'            => $updated_by
        ]);
    }




    // Lấy tất cả loại hình thanh toán
    public function getPaymentTypes()
    {
        $sql = "SELECT * FROM payment_type ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả trạng thái thanh toán
    public function getPaymentStatusType()
    {
        $sql = "SELECT * FROM payment_status_type ORDER BY id ASC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getPaymentStatusType()
    // {
    //     $sql = "SELECT * FROM payment_status_type ORDER BY id ASC";
    //     $stmt = $this->conn->query($sql);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public function getLatestBookingPriceByBookingId(int $booking_id)
    {
        $sql = "SELECT * FROM booking_prices 
            WHERE booking_id = :booking_id 
            ORDER BY updated_at DESC 
            LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // trả về 1 dòng
    }


    // Insert booking prices
    public function InsertBookingPrices($data)
    {
        try {
            $sql = "INSERT INTO booking_prices 
            (booking_id, passenger_prices, service_prices, total_price, paid_amount, currency, notes, created_at, updated_at)
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                $data['booking_id'],
                $data['passenger_prices'] ?? 0,
                $data['service_prices'] ?? 0,
                $data['total_price'] ?? 0,
                $data['paid_amount'] ?? 0,
                $data['currency'] ?? 'VND',
                $data['notes'] ?? null
            ]);

            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            // In lỗi ra để debug
            echo "Lỗi insert booking_prices: " . $e->getMessage();
            return false; // hoặc throw lại nếu muốn dừng
        }
    }

    public function updatePaidAmount(int $booking_id, float $paid_amount): bool
    {
        // echo "<pre>";
        // echo "== DEBUG INPUT ==\n";
        // var_dump($booking_id, $paid_amount);
        // echo "</pre>";
        // die;

        $price = $this->getLatestBookingPriceByBookingId($booking_id);

        if (!$price) {
            return false;
        }

        $updateSql = "UPDATE booking_prices 
                    SET paid_amount = :paid_amount,
                        updated_at = NOW()
                    WHERE id = :id";

        $updateStmt = $this->conn->prepare($updateSql);

        return $updateStmt->execute([
            ':paid_amount' => $paid_amount,
            ':id'          => $price['id']
        ]);
    }
}
