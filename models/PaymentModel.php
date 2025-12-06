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
        $sql = "SELECT * FROM payments_logs WHERE booking_id = :booking_id ORDER BY created_at ASC";
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
        string $transaction_code,
        ?string $payment_image = null,
        ?string $note = null
    ): bool {
        $sql = "INSERT INTO payments_logs 
        (booking_id, amount, payment_method_id, payment_type_id, transaction_code, payment_image, note, created_at)
        VALUES 
        (:booking_id, :amount, :payment_method_id, :payment_type_id, :transaction_code, :payment_image, :note, NOW())";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':booking_id'        => $booking_id,
            ':amount'            => $amount,
            ':payment_method_id' => $payment_method_id,
            ':payment_type_id'   => $payment_type_id,
            ':transaction_code'  => $transaction_code,
            ':payment_image'     => $payment_image,
            ':note'              => $note
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
