<?php
class PaymentModel
{
    private $conn;
    protected $table = 'booking_payments';

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getPaymentModel(): array
    {
        $sql = "SELECT * FROM `payment_methods` ORDER BY `id` ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPayment(array $data): bool
    {
        $sql = "INSERT INTO {$this->table} 
            (booking_id, amount, payment_method_id, payment_type_id, transaction_code, payment_image, created_at)
            VALUES (:booking_id, :amount, :payment_method_id, :payment_type_id, :transaction_code, :payment_image, :created_at)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':booking_id' => $data['booking_id'],
            ':amount' => $data['amount'],
            ':payment_method_id' => $data['payment_method_id'],
            ':payment_type_id' => $data['payment_type_id'],
            ':transaction_code' => $data['transaction_code'],
            ':payment_image' => $data['payment_image'],
            ':created_at' => $data['created_at'],
        ]);
    }
}
