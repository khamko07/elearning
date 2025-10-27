<style>
.about-container {
    max-width: 900px;
    margin: 0 auto;
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.about-image {
    text-align: center;
    margin-bottom: 30px;
}

.about-image img {
    max-width: 40%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.about-content {
    line-height: 1.8;
    font-size: 16px;
    color: #333;
}

.about-content h1 {
    color: #2c3e50;
    font-size: 2.5em;
    margin-bottom: 30px;
    text-align: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.about-content p {
    margin-bottom: 20px;
    text-align: justify;
    text-indent: 30px;
}

.about-content p:last-child {
    text-align: center;
    font-weight: 600;
    color: #667eea;
    font-style: italic;
}

@media (max-width: 768px) {
    .about-container {
        padding: 25px 20px;
        margin: 0 10px;
    }
    
    .about-content h1 {
        font-size: 2em;
    }
    
    .about-content {
        font-size: 15px;
    }
}
</style>

<div class="about-container">
    <div class="about-image">
        <img src="assets/fim.jpg" alt="FIM University">
    </div>
    
    <div class="about-content">
        <h1><?php echo $title;?></h1>
        
        <p>
            Trước hết, em xin gửi lời cảm ơn chân thành và sâu sắc nhất đến thầy TS. 
            Trần Văn Hưng, giảng viên khoa Tin Học - Trường Đại học sư phạm Đà Nẵng, 
            người đã tận tình hướng dẫn, chỉ bảo và động viên em trong suốt quá trình thực 
            hiện đồ án chuyên ngành này.
        </p>
        
        <p>
            Em cũng xin bày tỏ lòng biết ơn đến các Thầy Cô giáo trong khoa Tin 
            Học, đã truyền đạt cho tôi những kiến thức quý báu và cần thiết để hoàn thành 
            đồ án này.
        </p>
        
        <p>
            Đồ án chuyên ngành với đề tài "Xây dựng website bán điện thoại" là kết 
            quả của quá trình cố gắng không ngừng của bản thân em và được sự giúp đỡ, 
            động viên khích lệ của các thầy cô giáo, gia đình và bạn bè. Em xin chân thành 
            cảm ơn tất cả những người đã giúp đỡ em trong quá trình thực hiện đồ án.
        </p>
        
        <p>Một lần nữa em xin chân thành cảm ơn!</p>
    </div>
</div>