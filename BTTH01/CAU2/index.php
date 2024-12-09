<?php
// Đọc dữ liệu từ tệp questions.txt
$filename = "questions.txt";
$questions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Phân tích dữ liệu câu hỏi và đáp án
$current_question = [];
$all_questions = [];
foreach ($questions as $line) {
    // Kiểm tra dòng bắt đầu với "Câu" để phân biệt câu hỏi
    if (strpos($line, "Câu") === 0) {
        if (!empty($current_question)) {
            $all_questions[] = $current_question;
        }
        $current_question = [];
    }
    $current_question[] = $line;
}
// Lưu câu hỏi cuối cùng
if (!empty($current_question)) {
    $all_questions[] = $current_question;
}

// Kiểm tra xem mảng câu hỏi có chứa dữ liệu không
if (empty($all_questions)) {
    echo "Không có câu hỏi nào được đọc từ tệp.";
}

// Xử lý kết quả bài nộp
$score = 0;
$incorrect_answers = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answers = [];
    $user_answers = [];
    foreach ($all_questions as $question) {
        // Tìm đáp án đúng trong câu hỏi
        preg_match('/Đáp án: (.)/', $question[5], $matches);
        $answers[] = $matches[1]; // Đáp án đúng
    }

    foreach ($_POST as $key => $userAnswer) {
        $questionNumber = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT);
        $user_answers[$questionNumber] = $userAnswer;

        if (isset($answers[$questionNumber - 1]) && $answers[$questionNumber - 1] === $userAnswer) {
            $score++;
        } else {
            $incorrect_answers[] = [
                'question' => $all_questions[$questionNumber - 1][0], // Câu hỏi
                'correct' => $answers[$questionNumber - 1], // Đáp án đúng
                'user' => $userAnswer // Đáp án người dùng chọn
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trắc Nghiệm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Bài Trắc Nghiệm</h2>
    <form action="index.php" method="post">
        <?php foreach ($all_questions as $index => $question): ?>
            <div class="card mb-4">
                <div class="card-header"><strong><?php echo $question[0]; ?></strong></div>
                <div class="card-body">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                        <?php
                        $answer = substr($question[$i], 0, 1); // A, B, C, D
                        $label = substr($question[$i], 3); // Đáp án A, B, C, D
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="question<?php echo $index + 1; ?>" value="<?php echo $answer; ?>" id="question<?php echo $index + 1 . $answer; ?>" 
                            <?php echo isset($user_answers[$index + 1]) && $user_answers[$index + 1] === $answer ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="question<?php echo $index + 1 . $answer; ?>"><?php echo $label; ?></label>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Nộp bài</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <div class="alert alert-success text-center mt-4">
            Bạn trả lời đúng <strong><?php echo $score; ?></strong>/<?php echo count($all_questions); ?> câu.
        </div>

        <h4>Chi tiết kết quả:</h4>
        <ul class="list-group">
            <?php foreach ($incorrect_answers as $incorrect): ?>
                <li class="list-group-item">
                    <strong>Câu:</strong> <?php echo $incorrect['question']; ?><br>
                    <strong>Đáp án đúng:</strong> <?php echo $incorrect['correct']; ?><br>
                    <strong>Câu trả lời của bạn:</strong> <?php echo $incorrect['user']; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <a href="index.php" class="btn btn-primary mt-3">Làm lại</a>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
