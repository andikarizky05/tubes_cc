pipeline {
    agent any

    triggers {
        // Mengandalkan webhook untuk mendeteksi perubahan
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

        stage('Show Changes') {
            steps {
                echo 'Displaying commit or push details...'
                sh 'git log -1 --pretty=format:"%h - %an, %ar : %s"' // Menampilkan commit terbaru
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
