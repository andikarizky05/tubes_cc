pipeline {
    agent any

    triggers {
        // Mengaktifkan polling SCM (opsional, jika webhook tidak tersedia)
        pollSCM('H/5 * * * *') // Memeriksa perubahan setiap 5 menit
    }

    stages {
        stage('Checkout') {
            steps {
                // Checkout kode dari repository GitHub
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/main']], // Sesuaikan dengan branch utama Anda
                    doGenerateSubmoduleConfigurations: false,
                    extensions: [],
                    userRemoteConfigs: [[url: 'https://github.com/andikarizky05/tubes_cc.git']] // Ganti dengan URL repository Anda
                ])
            }
        }

        stage('Build') {
            steps {
                echo 'Building the application...'
                // Menjalankan langkah build
                sh 'mvn clean package' // Contoh perintah build menggunakan Maven
            }
        }

        stage('Test') {
            steps {
                echo 'Running tests...'
                // Tambahkan langkah pengujian sesuai kebutuhan
            }
        }

        stage('Deploy') {
            steps {
                echo 'Deploying the application...'
                // Tambahkan langkah deploy sesuai kebutuhan
            }
        }
    }

    post {
        always {
            echo 'Pipeline completed.'
        }
        success {
            echo 'Pipeline succeeded.'
        }
        failure {
            echo 'Pipeline failed.'
        }
    }
}
