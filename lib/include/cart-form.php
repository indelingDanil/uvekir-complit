<?php
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/send-email/', array(
        'methods' => 'POST',
        'callback' => 'send_email',
        'permission_callback' => '__return_true',
    ));
});

function send_email(WP_REST_Request $request)
{
    $params = $request->get_params();

    // Указываем email получателя
    $to = 'indeling@yandex.ru';  // Замените на ваш email

    // Получаем данные из запроса
    $name = sanitize_text_field($params['name']);
    $message = sanitize_textarea_field($params['message']);
    $email = sanitize_email($params['email']);  // Добавлено поле email для заголовка

    // Корзина включена в поле message

    // Тема письма
    $subject = "Новый заказ от " . $name;

    // Формируем полное сообщение для письма
    $full_message = "" . $message . "\n\n";

    // Устанавливаем заголовки для письма
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Your Website <info@yourwebsite.com>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Отправляем письмо
    if (wp_mail($to, $subject, $full_message, $headers)) {
        return new WP_REST_Response(['success' => true, 'message' => 'Email sent successfully'], 200);
    } else {
        $error = error_get_last();
        error_log('Failed to send email: ' . print_r($error, true)); // Запись в лог ошибок
        return new WP_REST_Response(['success' => false, 'message' => 'Failed to send email'], 500);
    }
}
?>