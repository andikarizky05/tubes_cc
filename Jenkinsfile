pipeline {
    agent any

    triggers {
        // Mengandalkan webhook untuk mendeteksi perubahan
    }

    stages {
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
