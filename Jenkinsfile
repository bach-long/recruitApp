pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                git 'https://github.com/bach-long/recruitApp.git'
                dir('be') {
                    sh 'composer install --ignore-platform-reqs'
                    sh 'cp .env.example .env'
                    sh 'php artisan key:generate'
                }
            }
        }
        stage('Check Convention') {
            steps {
                // Sử dụng công cụ Pint để kiểm tra convention
                dir('be') {
                    sh './vendor/bin/pint --test'
                }
            }
        }
    }

    post {
        success {
            // Hành động sau khi pipeline chạy thành công
            echo 'Pipeline ran successfully!'
        }
        failure {
            // Hành động sau khi pipeline thất bại
            echo 'Pipeline failed!'
        }
    }
}