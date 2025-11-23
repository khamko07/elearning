                      <?php 
                         if (!isset($_SESSION['USERID'])){
                              redirect(web_root."admin/index.php");
                             }

                      // $autonum = New Autonumber();
                      // $res = $autonum->single_autonumber(2);
                      
                      // Get pre-selected category from URL (if coming from topics page)
                      $preSelectedCategoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;
                      $preSelectedCategory = null;
                      
                      if ($preSelectedCategoryId > 0) {
                          $sql = "SELECT * FROM tblcategories WHERE CategoryID = {$preSelectedCategoryId}";
                          $mydb->setQuery($sql);
                          $preSelectedCategory = $mydb->loadSingleResult();
                      }

                       ?> 
<div class="row mb-4">
  <div class="col-lg-12">
    <h1 class="page-header">
      <i class="fas fa-question-circle me-2"></i>Add New Question
    </h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <form action="controller.php?action=add" method="POST">
      
      <!-- AI Question Generator Section -->
      <div class="card mb-4">
        <div class="card-header bg-gradient-primary text-white">
          <h5 class="mb-0">
            <i class="fas fa-magic me-2"></i>AI Question Generator
          </h5>
        </div>
        <div class="card-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2"></i>
            Tự động tạo câu hỏi trắc nghiệm bằng AI. Chỉ cần nhập chủ đề và chọn độ khó!
          </p>
          <div class="row g-3">
            <div class="col-md-4">
              <label for="aiTopic" class="form-label">AI Topic (auto-filled):</label>
              <input type="text" class="form-control" id="aiTopic" placeholder="Chọn Category và Topic trước" readonly style="background-color: #f5f5f5;">
              <small class="form-text text-muted">Sẽ tự động điền khi bạn chọn Category và Topic</small>
            </div>
            <div class="col-md-3">
              <label for="difficulty" class="form-label">Độ khó:</label>
              <select class="form-select" id="difficulty">
                <option value="dễ">Dễ</option>
                <option value="trung bình" selected>Trung bình</option>
                <option value="khó">Khó</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="numQuestions" class="form-label">Số lượng câu hỏi:</label>
              <select class="form-select" id="numQuestions">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">&nbsp;</label>
              <button type="button" class="btn btn-success w-100" id="generateQuestion">
                <i class="fas fa-magic me-1"></i>Tạo Câu Hỏi
              </button>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <div id="loadingIndicator" class="alert alert-info" style="display: none;">
                <div class="spinner-border spinner-border-sm me-2" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                <i class="fas fa-spinner fa-spin me-2"></i>Đang tạo câu hỏi với AI...
              </div>
              <div id="aiError" class="alert alert-danger" style="display: none;"></div>
              
              <!-- Info message for bulk operations -->
              <div id="bulkInfoMessage" class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Hướng dẫn Bulk Insert:</strong>
                Nhập chủ đề và click "Tạo Câu Hỏi" để AI tạo nhiều câu hỏi, sau đó bạn có thể chọn "Select All" và "Insert Selected" để thêm nhiều câu cùng lúc.
              </div>
                                        
              <!-- Multiple Questions Result Section -->
              <div id="multipleQuestionsSection" style="display: none; margin-top: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>Câu hỏi đã tạo: <span id="questionCount" class="badge bg-primary">0</span>
                  </h5>
                  <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="selectAllQuestions">
                      <i class="fas fa-check-square me-1"></i>Select All
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="deselectAllQuestions">
                      <i class="far fa-square me-1"></i>Deselect All
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="bulkInsertQuestions" disabled>
                      <i class="fas fa-plus-circle me-1"></i>Insert Selected (<span id="selectedCount">0</span>)
                    </button>
                  </div>
                </div>
                <div id="questionsList" class="accordion" style="margin-top: 15px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Form Section -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>Question Details
          </h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="Category" class="form-label">
              <i class="fas fa-folder me-1"></i>Category <span class="text-danger">*</span>
            </label>
            <div>
              <?php if ($preSelectedCategory): ?>
                <!-- Category is locked when coming from specific category page -->
                <div class="input-group">
                  <input type="text" class="form-control" id="LockedCategoryName" value="<?php echo $preSelectedCategory->CategoryName; ?>" readonly style="background-color: #f0f0f0; cursor: not-allowed;" data-category-name="<?php echo htmlspecialchars($preSelectedCategory->CategoryName); ?>">
                  <span class="input-group-text" title="Category is locked">
                    <i class="fas fa-lock"></i>
                  </span>
                </div>
                <input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $preSelectedCategory->CategoryID; ?>">
                <input type="hidden" name="CategorySelect" id="CategorySelect" value="<?php echo $preSelectedCategory->CategoryID; ?>">
                <input type="hidden" name="Category" id="CategoryInput" value="">
                <small class="form-text text-info mt-1">
                  <i class="fas fa-lock me-1"></i>
                  Category is locked to <strong><?php echo $preSelectedCategory->CategoryName; ?></strong>
                </small>
              <?php else: ?>
                <!-- Normal category selection -->
                <div class="input-group">
                  <select class="form-select" name="CategorySelect" id="CategorySelect" onchange="handleCategorySelect()">
                    <option value="">-- Chọn từ danh sách có sẵn --</option>
                    <?php
                    $sql = "SELECT * FROM tblcategories WHERE IsActive = 1 ORDER BY CategoryName";
                    $mydb->setQuery($sql);
                    $categories = $mydb->loadResultList();
                    foreach ($categories as $category) {
                      echo '<option value="'.$category->CategoryID.'" data-name="'.$category->CategoryName.'">'.$category->CategoryName.'</option>';
                    }
                    ?>
                    <option value="new">✏️ Nhập Category mới...</option>
                  </select>
                  <span class="input-group-text" style="cursor: pointer;" onclick="toggleCategoryInput()" title="Nhập tên mới">
                    <i class="fas fa-edit"></i>
                  </span>
                </div>
                <input type="text" class="form-control mt-2" name="Category" id="CategoryInput" 
                       placeholder="Nhập tên Category mới (ví dụ: Lịch sử, Địa lý...)" 
                       style="display: none;">
                <input type="hidden" name="CategoryID" id="CategoryID" value="">
                <small class="form-text text-muted mt-1">
                  <i class="fas fa-info-circle me-1"></i>
                  Chọn từ danh sách hoặc nhập tên mới
                </small>
              <?php endif; ?>
            </div>
          </div>
                      
          <div class="mb-3">
            <label for="Topic" class="form-label">
              <i class="fas fa-tag me-1"></i>Topic <span class="text-danger">*</span>
            </label>
            <div class="input-group">
              <select class="form-select" name="TopicSelect" id="TopicSelect" onchange="handleTopicSelect()">
                <option value="">-- Chọn Category trước --</option>
              </select>
              <span class="input-group-text" style="cursor: pointer;" onclick="toggleTopicInput()" title="Nhập tên mới">
                <i class="fas fa-edit"></i>
              </span>
            </div>
            <input type="text" class="form-control mt-2" name="Topic" id="TopicInput" 
                   placeholder="Nhập tên Topic mới (ví dụ: Chiến tranh thế giới, Khí hậu nhiệt đới...)" 
                   style="display: none;">
            <input type="hidden" name="TopicID" id="TopicID" value="">
            <small class="form-text text-muted mt-1">
              <i class="fas fa-info-circle me-1"></i>
              Chọn từ danh sách hoặc nhập tên mới
            </small>
          </div>
                      
          <div class="mb-3">
            <a href="index.php?view=categories" class="btn btn-outline-info btn-sm">
              <i class="fas fa-cog me-1"></i>Quản lý Categories & Topics
            </a>
          </div>
          
          <div class="mb-3">
            <label for="Question" class="form-label">
              <i class="fas fa-question me-1"></i>Question <span class="text-danger">*</span>
            </label>
            <textarea class="form-control" id="Question" name="Question" placeholder="Question Name" rows="3" required></textarea>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="ChoiceA" class="form-label">
                <i class="fas fa-circle me-1 text-primary"></i>Choice A <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceA" name="ChoiceA" placeholder="Enter choice A" type="text" value="" required>
            </div>

            <div class="col-md-6">
              <label for="ChoiceB" class="form-label">
                <i class="fas fa-circle me-1 text-success"></i>Choice B <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceB" name="ChoiceB" placeholder="Enter choice B" type="text" value="" required>
            </div>

            <div class="col-md-6">
              <label for="ChoiceC" class="form-label">
                <i class="fas fa-circle me-1 text-warning"></i>Choice C <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceC" name="ChoiceC" placeholder="Enter choice C" type="text" value="" required>
            </div>

            <div class="col-md-6">
              <label for="ChoiceD" class="form-label">
                <i class="fas fa-circle me-1 text-danger"></i>Choice D <span class="text-danger">*</span>
              </label>
              <input class="form-control" id="ChoiceD" name="ChoiceD" placeholder="Enter choice D" type="text" value="" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="Answer" class="form-label">
              <i class="fas fa-check-circle me-1"></i>Correct Answer <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="Answer" name="Answer" required>
              <option value="">-- Select correct answer --</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
            <small class="form-text text-muted mt-1">Select the correct answer from choices above</small>
          </div>

          <div class="d-flex gap-2 mt-4">
            <button class="btn btn-primary" name="save" type="submit">
              <i class="fas fa-save me-2"></i>Save
            </button>
            <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
              <i class="fas fa-redo me-2"></i>Clear Form
            </button>
            <a href="index.php" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- API Configuration removed - now using hardcoded API key -->

<style>
/* Category/Topic Input Styling */
.input-group-addon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.input-group-addon:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: scale(1.05);
}

#CategoryInput,
#TopicInput {
    border: 2px dashed #667eea;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

#CategoryInput:focus,
#TopicInput:focus {
    border-color: #764ba2;
    background: white;
    box-shadow: 0 0 10px rgba(102, 126, 234, 0.3);
}

#CategorySelect,
#TopicSelect {
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

#CategorySelect:focus,
#TopicSelect:focus {
    border-color: #667eea;
    box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
}

#multipleQuestionsSection {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #dee2e6;
}

#multipleQuestionsSection h5 {
    color: #495057;
    margin-bottom: 15px;
}

.panel {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.panel:hover {
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.panel-heading {
    background-color: #e9ecef;
    border-bottom: 1px solid #dee2e6;
    border-radius: 6px 6px 0 0;
    padding: 12px 15px;
}

.panel-body {
    padding: 15px;
    background-color: white;
}

.panel-body p {
    margin-bottom: 8px;
    line-height: 1.4;
}

.btn-sm {
    margin: 0 5px;
}

.question-card {
    transition: all 0.3s ease;
}

.question-card.selected {
    background-color: #e8f5e8 !important;
    border-color: #28a745 !important;
    border-width: 2px !important;
}

.question-selector {
    transform: scale(1.3);
    margin-right: 10px;
}

.question-selector:checked {
    accent-color: #28a745;
}

#bulkInsertQuestions:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#bulkInsertQuestions:not(:disabled) {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.panel-heading label {
    font-weight: normal;
    width: 100%;
    margin: 0;
}

.panel-heading input[type="checkbox"] {
    margin-right: 8px;
}

#questionCount {
    color: #007bff;
    font-weight: bold;
}
</style>

<script>
// Gemini API Integration - Simplified version

document.getElementById('generateQuestion').addEventListener('click', function() {
    const topic = document.getElementById('aiTopic').value.trim();
    const difficulty = document.getElementById('difficulty').value;
    const numQuestions = parseInt(document.getElementById('numQuestions').value, 10);
    
    if (!topic) {
        alert('Vui lòng chọn Category và Topic trước khi tạo câu hỏi.');
        return;
    }
    if (isNaN(numQuestions) || numQuestions < 1 || numQuestions > 10) {
        alert('Số lượng câu hỏi phải từ 1 đến 10.');
        return;
    }
    generateQuestionWithAI(topic, difficulty, numQuestions);
});

async function generateQuestionWithAI(topic, difficulty, numQuestions) {
    const loadingIndicator = document.getElementById('loadingIndicator');
    const errorDiv = document.getElementById('aiError');
    
    // Show loading
    loadingIndicator.style.display = 'block';
    errorDiv.style.display = 'none';

    try {
        // Use test API that tries multiple models (no session required)
        const response = await fetch('gemini_api_test.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topic: topic,
                difficulty: difficulty,
                numQuestions: numQuestions
            })
        });

        // Debug: Get raw response text first
        const responseText = await response.text();
        console.log('Raw response:', responseText);
        
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (parseError) {
            throw new Error('Invalid JSON response: ' + parseError.message + '. Response: ' + responseText.substring(0, 200));
        }

        if (!response.ok) {
            throw new Error(result.error || `Lỗi server: ${response.status}`);
        }

        if (!result.success) {
            throw new Error(result.error || 'Không thể tạo câu hỏi');
        }
        
        // Handle response based on number of questions
        if (result.count && result.count > 1) {
            // Multiple questions - show selection interface
            displayMultipleQuestions(result.data, result.count);
        } else {
            // Single question - fill form directly
            const questionData = Array.isArray(result.data) ? result.data[0] : result.data;
            fillFormWithQuestionData(questionData);
            showSuccessMessage('Tạo câu hỏi thành công! Vui lòng kiểm tra và chỉnh sửa nếu cần.');
        }
        
        loadingIndicator.style.display = 'none';
        
    } catch (error) {
        console.error('Error generating question:', error);
        errorDiv.innerHTML = `<strong>Lỗi:</strong> ${error.message}`;
        errorDiv.style.display = 'block';
        loadingIndicator.style.display = 'none';
    }
}

function extractQuestionData(text) {
    // Fallback method to extract question data if JSON parsing fails
    const lines = text.split('\n');
    let questionData = {
        question: '',
        choices: { A: '', B: '', C: '', D: '' },
        answer: 'A'
    };
    
    // Simple extraction logic - this is a fallback
    for (let line of lines) {
        if (line.includes('question') && line.includes(':')) {
            questionData.question = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"A"') && line.includes(':')) {
            questionData.choices.A = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"B"') && line.includes(':')) {
            questionData.choices.B = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"C"') && line.includes(':')) {
            questionData.choices.C = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"D"') && line.includes(':')) {
            questionData.choices.D = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('answer') && line.includes(':')) {
            questionData.answer = line.split(':')[1].replace(/['"]/g, '').trim();
        }
    }
    
    return questionData;
}

function displayMultipleQuestions(questions, count) {
    const multipleSection = document.getElementById('multipleQuestionsSection');
    const questionsList = document.getElementById('questionsList');
    const questionCount = document.getElementById('questionCount');
    
    // Clear previous results
    questionsList.innerHTML = '';
    if (questionCount) {
        questionCount.textContent = count;
    }
    
    // Create question cards with checkboxes
    questions.forEach((question, index) => {
        const questionCard = document.createElement('div');
        questionCard.className = 'panel panel-default question-card';
        questionCard.style.marginBottom = '15px';
        questionCard.setAttribute('data-index', index);
        
        questionCard.innerHTML = `
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-1">
                        <input type="checkbox" class="question-selector" data-index="${index}" id="question_${index}">
                    </div>
                    <div class="col-md-11">
                        <h6 class="panel-title">
                            <label for="question_${index}" style="cursor: pointer; margin: 0;">
                                <strong>Câu hỏi ${index + 1}:</strong> ${question.question}
                            </label>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>A:</strong> ${question.choices.A}</p>
                        <p><strong>B:</strong> ${question.choices.B}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>C:</strong> ${question.choices.C}</p>
                        <p><strong>D:</strong> ${question.choices.D}</p>
                        <p><strong style="color: green;">Đáp án đúng:</strong> ${question.answer}</p>
                    </div>
                </div>
                <div class="text-center" style="margin-top: 15px;">
                    <button type="button" class="btn btn-primary btn-sm" onclick="useThisQuestion(${index})">
                        <i class="fa fa-check"></i> Sử dụng câu hỏi này
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="copyQuestionText(${index})">
                        <i class="fa fa-copy"></i> Copy câu hỏi
                    </button>
                </div>
            </div>
        `;
        
        questionsList.appendChild(questionCard);
    });
    
    // Store questions globally for use in button handlers
    window.generatedQuestions = questions;
    
    // Initialize bulk selection functionality
    initializeBulkSelection();
    
    // Show the section and hide info message
    if (multipleSection) {
        multipleSection.style.display = 'block';
    }
    
    const infoMessage = document.getElementById('bulkInfoMessage');
    if (infoMessage) {
        infoMessage.style.display = 'none';
    }
    
    // Show success message
    showSuccessMessage(`Tạo thành công ${count} câu hỏi! Chọn câu hỏi bạn muốn sử dụng.`);
}

function useThisQuestion(index) {
    if (window.generatedQuestions && window.generatedQuestions[index]) {
        fillFormWithQuestionData(window.generatedQuestions[index]);
        
        // Scroll to form
        document.getElementById('Question').scrollIntoView({ behavior: 'smooth' });
        
        // Highlight the selected question briefly
        const questionCards = document.querySelectorAll('.panel');
        if (questionCards[index]) {
            questionCards[index].style.backgroundColor = '#d4edda';
            setTimeout(() => {
                questionCards[index].style.backgroundColor = '';
            }, 2000);
        }
        
        showSuccessMessage('Đã điền câu hỏi vào form! Vui lòng kiểm tra và chỉnh sửa nếu cần.');
    }
}

function copyQuestionText(index) {
    if (window.generatedQuestions && window.generatedQuestions[index]) {
        const question = window.generatedQuestions[index];
        const text = `Câu hỏi: ${question.question}
A: ${question.choices.A}
B: ${question.choices.B}
C: ${question.choices.C}
D: ${question.choices.D}
Đáp án: ${question.answer}`;
        
        navigator.clipboard.writeText(text).then(() => {
            showSuccessMessage('Đã copy câu hỏi vào clipboard!');
        }).catch(err => {
            console.error('Could not copy text: ', err);
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showSuccessMessage('Đã copy câu hỏi vào clipboard!');
        });
    }
}

function fillFormWithQuestionData(data) {
    // Fill the form fields
    document.getElementById('Question').value = data.question || '';
    document.getElementById('ChoiceA').value = data.choices.A || '';
    document.getElementById('ChoiceB').value = data.choices.B || '';
    document.getElementById('ChoiceC').value = data.choices.C || '';
    document.getElementById('ChoiceD').value = data.choices.D || '';
    document.getElementById('Answer').value = data.answer || '';
}

function clearForm() {
    document.getElementById('Question').value = '';
    document.getElementById('ChoiceA').value = '';
    document.getElementById('ChoiceB').value = '';
    document.getElementById('ChoiceC').value = '';
    document.getElementById('ChoiceD').value = '';
    document.getElementById('Answer').value = '';
    
    // Reset category fields
    document.getElementById('CategorySelect').value = '';
    document.getElementById('CategoryInput').value = '';
    document.getElementById('CategoryInput').style.display = 'none';
    document.getElementById('CategoryID').value = '';
    
    // Reset topic fields
    document.getElementById('TopicSelect').innerHTML = '<option value="">-- Chọn Category trước --</option>';
    document.getElementById('TopicInput').value = '';
    document.getElementById('TopicInput').style.display = 'none';
    document.getElementById('TopicID').value = '';
    
    document.getElementById('aiTopic').value = '';
}

// Handle Category Select
function handleCategorySelect() {
    const categorySelect = document.getElementById('CategorySelect');
    const categoryInput = document.getElementById('CategoryInput');
    const categoryIdHidden = document.getElementById('CategoryID');
    const selectedOption = categorySelect.options[categorySelect.selectedIndex];
    
    if (categorySelect.value === 'new') {
        // Show input field for new category
        categoryInput.style.display = 'block';
        categoryInput.required = true;
        categoryInput.focus();
        categoryIdHidden.value = '';
    } else if (categorySelect.value) {
        // Use existing category
        categoryInput.style.display = 'none';
        categoryInput.required = false;
        categoryInput.value = '';
        categoryIdHidden.value = categorySelect.value;
        
        // Load topics for this category
        loadTopics(categorySelect.value);
    } else {
        // No selection
        categoryInput.style.display = 'none';
        categoryInput.required = false;
        categoryInput.value = '';
        categoryIdHidden.value = '';
        
        // Reset topics
        const topicSelect = document.getElementById('TopicSelect');
        topicSelect.innerHTML = '<option value="">-- Chọn Category trước --</option>';
        document.getElementById('TopicInput').style.display = 'none';
    }
    
    updateAITopic();
}

// Handle Topic Select
function handleTopicSelect() {
    const topicSelect = document.getElementById('TopicSelect');
    const topicInput = document.getElementById('TopicInput');
    const topicIdHidden = document.getElementById('TopicID');
    
    if (topicSelect.value === 'new') {
        // Show input field for new topic
        topicInput.style.display = 'block';
        topicInput.required = true;
        topicInput.focus();
        topicIdHidden.value = '';
    } else if (topicSelect.value) {
        // Use existing topic
        topicInput.style.display = 'none';
        topicInput.required = false;
        topicInput.value = '';
        topicIdHidden.value = topicSelect.value;
    } else {
        // No selection
        topicInput.style.display = 'none';
        topicInput.required = false;
        topicInput.value = '';
        topicIdHidden.value = '';
    }
    
    updateAITopic();
}

// Toggle Category Input manually
function toggleCategoryInput() {
    const categoryInput = document.getElementById('CategoryInput');
    const categorySelect = document.getElementById('CategorySelect');
    
    if (categoryInput.style.display === 'none' || !categoryInput.style.display) {
        categoryInput.style.display = 'block';
        categoryInput.required = true;
        categoryInput.focus();
        categorySelect.value = '';
        document.getElementById('CategoryID').value = '';
    } else {
        categoryInput.style.display = 'none';
        categoryInput.required = false;
        categoryInput.value = '';
    }
    
    updateAITopic();
}

// Toggle Topic Input manually
function toggleTopicInput() {
    const topicInput = document.getElementById('TopicInput');
    const topicSelect = document.getElementById('TopicSelect');
    
    if (topicInput.style.display === 'none' || !topicInput.style.display) {
        topicInput.style.display = 'block';
        topicInput.required = true;
        topicInput.focus();
        topicSelect.value = '';
        document.getElementById('TopicID').value = '';
    } else {
        topicInput.style.display = 'none';
        topicInput.required = false;
        topicInput.value = '';
    }
    
    updateAITopic();
}

// Load topics when category is selected
function loadTopics(categoryId) {
    const topicSelect = document.getElementById('TopicSelect');
    
    if (!categoryId) {
        topicSelect.innerHTML = '<option value="">-- Chọn Category trước --</option>';
        updateAITopic();
        return;
    }
    
    // Show loading
    topicSelect.innerHTML = '<option value="">⏳ Đang tải topics...</option>';
    
    fetch('get_topics.php?categoryId=' + categoryId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                topicSelect.innerHTML = '<option value="">-- Chọn từ danh sách có sẵn --</option>';
                data.topics.forEach(topic => {
                    topicSelect.innerHTML += `<option value="${topic.TopicID}">${topic.TopicName}</option>`;
                });
                topicSelect.innerHTML += '<option value="new">✏️ Nhập Topic mới...</option>';
            } else {
                topicSelect.innerHTML = '<option value="">❌ Lỗi tải topics</option>';
            }
            updateAITopic();
        })
        .catch(error => {
            console.error('Error:', error);
            topicSelect.innerHTML = '<option value="">❌ Lỗi kết nối</option>';
            updateAITopic();
        });
}

// Update AI topic field when Category/Topic changes
function updateAITopic() {
    const categorySelect = document.getElementById('CategorySelect');
    const categoryInput = document.getElementById('CategoryInput');
    const topicSelect = document.getElementById('TopicSelect');
    const topicInput = document.getElementById('TopicInput');
    const aiTopicField = document.getElementById('aiTopic');
    const categoryId = document.getElementById('CategoryID');
    
    if (!aiTopicField) return; // Safety check
    
    let categoryText = '';
    let topicText = '';
    
    // Get category text
    if (categoryInput && categoryInput.style.display !== 'none' && categoryInput.value.trim()) {
        categoryText = categoryInput.value.trim();
    } else if (categorySelect && categorySelect.value && categorySelect.value !== 'new' && categorySelect.selectedIndex >= 0) {
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        if (selectedOption) {
            categoryText = selectedOption.dataset.name || selectedOption.text;
        }
    } else {
        // When category is locked, get the text from locked field
        const lockedCategoryField = document.getElementById('LockedCategoryName');
        if (lockedCategoryField) {
            categoryText = lockedCategoryField.dataset.categoryName || lockedCategoryField.value;
        }
    }
    
    // Get topic text
    if (topicInput && topicInput.style.display !== 'none' && topicInput.value.trim()) {
        topicText = topicInput.value.trim();
    } else if (topicSelect && topicSelect.value && topicSelect.value !== 'new' && topicSelect.value !== '' && topicSelect.selectedIndex >= 0) {
        const selectedOption = topicSelect.options[topicSelect.selectedIndex];
        if (selectedOption) {
            topicText = selectedOption.text;
            // Skip special texts
            if (topicText.includes('Chọn') || topicText.includes('tải') || topicText.includes('Lỗi') || topicText.includes('Nhập')) {
                topicText = '';
            }
        }
    }
    
    // Combine category and topic
    if (categoryText && topicText) {
        aiTopicField.value = `${categoryText} - ${topicText}`;
    } else if (categoryText) {
        aiTopicField.value = categoryText;
    } else {
        aiTopicField.value = '';
    }
}

// Add event listeners for input fields
document.addEventListener('DOMContentLoaded', function() {
    const categoryInput = document.getElementById('CategoryInput');
    const topicInput = document.getElementById('TopicInput');
    
    if (categoryInput) {
        categoryInput.addEventListener('input', updateAITopic);
    }
    if (topicInput) {
        topicInput.addEventListener('input', updateAITopic);
    }
});

function showSuccessMessage(message) {
    // Create a temporary success alert
    const successDiv = document.createElement('div');
    successDiv.className = 'alert alert-success';
    successDiv.innerHTML = `<i class="fa fa-check"></i> ${message}`;
    successDiv.style.position = 'fixed';
    successDiv.style.top = '20px';
    successDiv.style.right = '20px';
    successDiv.style.zIndex = '9999';
    
    document.body.appendChild(successDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        document.body.removeChild(successDiv);
    }, 3000);
}

// Bulk Selection Functions
function initializeBulkSelection() {
    // Handle individual checkbox changes
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButtonState);
    });
    
    // Handle select all
    const selectAllBtn = document.getElementById('selectAllQuestions');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', selectAllQuestions);
    }
    
    // Handle deselect all
    const deselectAllBtn = document.getElementById('deselectAllQuestions');
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', deselectAllQuestions);
    }
    
    // Handle bulk insert
    const bulkInsertBtn = document.getElementById('bulkInsertQuestions');
    if (bulkInsertBtn) {
        bulkInsertBtn.addEventListener('click', bulkInsertQuestions);
    }
    
    // Initial state update
    updateBulkButtonState();
}

function selectAllQuestions() {
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        checkbox.checked = true;
        highlightSelectedCard(checkbox);
    });
    updateBulkButtonState();
    showSuccessMessage('Đã chọn tất cả câu hỏi!');
}

function deselectAllQuestions() {
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        checkbox.checked = false;
        unhighlightSelectedCard(checkbox);
    });
    updateBulkButtonState();
    showSuccessMessage('Đã bỏ chọn tất cả câu hỏi!');
}

function updateBulkButtonState() {
    const selectedCheckboxes = document.querySelectorAll('.question-selector:checked');
    const selectedCount = selectedCheckboxes.length;
    const bulkButton = document.getElementById('bulkInsertQuestions');
    const countSpan = document.getElementById('selectedCount');
    
    if (countSpan) {
        countSpan.textContent = selectedCount;
    }
    
    if (bulkButton) {
        if (selectedCount > 0) {
            bulkButton.disabled = false;
            bulkButton.className = 'btn btn-success btn-sm';
        } else {
            bulkButton.disabled = true;
            bulkButton.className = 'btn btn-default btn-sm';
        }
    }
    
    // Update card highlighting
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        if (checkbox.checked) {
            highlightSelectedCard(checkbox);
        } else {
            unhighlightSelectedCard(checkbox);
        }
    });
}

function highlightSelectedCard(checkbox) {
    const card = checkbox.closest('.question-card');
    if (card) {
        card.style.backgroundColor = '#e8f5e8';
        card.style.borderColor = '#28a745';
        card.style.borderWidth = '2px';
    }
}

function unhighlightSelectedCard(checkbox) {
    const card = checkbox.closest('.question-card');
    if (card) {
        card.style.backgroundColor = '';
        card.style.borderColor = '';
        card.style.borderWidth = '';
    }
}

async function bulkInsertQuestions() {
    const selectedCheckboxes = document.querySelectorAll('.question-selector:checked');
    const selectedIndices = Array.from(selectedCheckboxes).map(cb => parseInt(cb.dataset.index));
    
    if (selectedIndices.length === 0) {
        alert('Vui lòng chọn ít nhất một câu hỏi để thêm!');
        return;
    }
    
    // Get Category and Topic first for validation
    const categoryId = document.getElementById('CategoryID').value;
    const topicId = document.getElementById('TopicID').value;
    
    // Get category name - check input, select, or locked field
    let categoryName = '';
    const categoryInput = document.getElementById('CategoryInput');
    const categorySelect = document.getElementById('CategorySelect');
    const lockedCategoryField = document.getElementById('LockedCategoryName');
    
    if (categoryInput && categoryInput.value.trim()) {
        categoryName = categoryInput.value.trim();
    } else if (categorySelect && categorySelect.tagName === 'SELECT' && categorySelect.selectedOptions && categorySelect.selectedOptions.length > 0) {
        categoryName = categorySelect.selectedOptions[0]?.dataset?.name || categorySelect.selectedOptions[0]?.text || '';
    } else if (lockedCategoryField) {
        categoryName = lockedCategoryField.dataset.categoryName || lockedCategoryField.value;
    }
    
    // Get topic name - check input or select
    let topicName = '';
    const topicInput = document.getElementById('TopicInput');
    const topicSelect = document.getElementById('TopicSelect');
    
    if (topicInput && topicInput.value.trim()) {
        topicName = topicInput.value.trim();
    } else if (topicSelect && topicSelect.selectedOptions && topicSelect.selectedOptions.length > 0) {
        topicName = topicSelect.selectedOptions[0]?.text || '';
    }
    
    // Validate Category
    if (!categoryName && !categoryId) {
        alert('Vui lòng chọn hoặc nhập Category trước khi thêm câu hỏi!');
        return;
    }
    
    // Validate Topic
    if (!topicName && !topicId) {
        alert('Vui lòng chọn hoặc nhập Topic trước khi thêm câu hỏi!');
        return;
    }
    
    // Use AI Topic field value for display
    const topicDisplay = document.getElementById('aiTopic').value || `${categoryName} - ${topicName}`;
    
    const confirmMessage = `Bạn có chắc chắn muốn thêm ${selectedIndices.length} câu hỏi với chủ đề "${topicDisplay}" không?\n\nThao tác này không thể hoàn tác!`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    // Show loading state
    const bulkButton = document.getElementById('bulkInsertQuestions');
    const originalText = bulkButton.innerHTML;
    bulkButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang thêm...';
    bulkButton.disabled = true;
    
    try {
        // Prepare questions data
        const questionsToInsert = selectedIndices.map(index => window.generatedQuestions[index]);
        
        console.log('Category ID:', categoryId);
        console.log('Category Name:', categoryName);
        console.log('Topic ID:', topicId);
        console.log('Topic Name:', topicName);
        console.log('Questions to insert:', questionsToInsert);
        
        // Send to simple bulk insert endpoint
        const response = await fetch('simple_bulk_insert.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topic: topicDisplay,
                categoryId: categoryId ? parseInt(categoryId) : null,
                topicId: topicId ? parseInt(topicId) : null,
                categoryName: categoryName,
                topicName: topicName,
                questions: questionsToInsert
            })
        });
        
        const responseText = await response.text();
        console.log('HTTP Status:', response.status);
        console.log('Raw response:', responseText);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${responseText}`);
        }
        
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Parse error:', parseError);
            throw new Error('Invalid JSON response: ' + responseText.substring(0, 200));
        }
        
        console.log('Parsed result:', result);
        
        if (result.success) {
            showSuccessMessage(`Đã thêm thành công ${result.inserted_count} câu hỏi!`);
            
            // Remove inserted questions from display
            selectedIndices.forEach(index => {
                const card = document.querySelector(`[data-index="${index}"]`);
                if (card) {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                    const checkbox = card.querySelector('.question-selector');
                    checkbox.checked = false;
                    checkbox.disabled = true;
                }
            });
            
            updateBulkButtonState();
            
            // Ask if user wants to go to question list
            setTimeout(() => {
                if (confirm('Câu hỏi đã được thêm thành công! Bạn có muốn xem danh sách câu hỏi không?')) {
                    window.location.href = 'index.php';
                }
            }, 1500);
            
        } else {
            throw new Error(result.error || 'Không thể thêm câu hỏi');
        }
        
    } catch (error) {
        console.error('Error bulk inserting questions:', error);
        alert(`Lỗi khi thêm câu hỏi: ${error.message}`);
    } finally {
        // Restore button state
        bulkButton.innerHTML = originalText;
        updateBulkButtonState();
    }
}

// Auto-load topics if category is pre-selected
document.addEventListener('DOMContentLoaded', function() {
    <?php if ($preSelectedCategory): ?>
    // Category is locked, load its topics automatically
    const categoryId = <?php echo $preSelectedCategory->CategoryID; ?>;
    const categoryName = '<?php echo addslashes($preSelectedCategory->CategoryName); ?>';
    console.log('Pre-selected category:', categoryId, categoryName);
    
    // Set initial AI topic with category name
    const aiTopicField = document.getElementById('aiTopic');
    if (aiTopicField) {
        aiTopicField.value = categoryName;
    }
    
    // Load topics for this category
    loadTopics(categoryId);
    <?php endif; ?>
});
</script>