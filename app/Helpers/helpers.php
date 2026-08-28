<?php

/**
 * ============================================================
 * Custom Global Helper Functions - QuickTask Project
 * ============================================================
 * File này chứa các hàm helper toàn cục (global functions)
 * có thể gọi trực tiếp ở bất kỳ đâu trong project:
 * Controller, View, Model, Command,...
 *
 * Cách đăng ký: khai báo trong composer.json > autoload > files
 * ============================================================
 */

if (! function_exists('format_number')) {
    /**
     * Quy đổi số thành dạng có dấu cách phân cách hàng nghìn.
     *
     * Ví dụ:
     *   format_number(123456789)   => '123 456 789'
     *   format_number(1000000)     => '1 000 000'
     *   format_number(9999.99)     => '9 999.99'
     *   format_number(-500000)     => '-500 000'
     *   format_number(0)           => '0'
     *
     * @param  int|float $number     Số cần định dạng
     * @param  int       $decimals   Số chữ số thập phân (mặc định 0)
     * @return string
     */
    function format_number(int|float $number, int $decimals = 0): string
    {
        // Dùng number_format với dấu phân cách hàng nghìn là khoảng trắng
        return number_format($number, $decimals, '.', ' ');
    }
}

if (! function_exists('format_currency')) {
    /**
     * Định dạng số thành tiền tệ VNĐ với dấu cách hàng nghìn.
     *
     * Ví dụ:
     *   format_currency(1500000) => '1 500 000 đ'
     *
     * @param  int|float $amount
     * @return string
     */
    function format_currency(int|float $amount): string
    {
        return format_number($amount) . ' đ';
    }
}

if (! function_exists('truncate_text')) {
    /**
     * Cắt ngắn chuỗi nếu vượt quá độ dài cho phép.
     *
     * Ví dụ:
     *   truncate_text('Đây là một đoạn văn rất dài', 15) => 'Đây là một đoạn...'
     *
     * @param  string $text      Chuỗi gốc
     * @param  int    $limit     Giới hạn ký tự (mặc định 100)
     * @param  string $end       Ký tự nối thêm nếu bị cắt (mặc định '...')
     * @return string
     */
    function truncate_text(string $text, int $limit = 100, string $end = '...'): string
    {
        return mb_strlen($text) > $limit
            ? mb_substr($text, 0, $limit) . $end
            : $text;
    }
}
