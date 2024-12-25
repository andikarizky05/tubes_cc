pipeline {
    agent any
    environment {
        // Define global variables for the pipeline
        GREETING = 'Hello, Jenkins Pipeline!'
        BUILD_TIMESTAMP = ''
    }
    stages {
        stage("Initialize") {
            steps {
                script {
                    // Get current timestamp
                    BUILD_TIMESTAMP = new Date().format("yyyy-MM-dd HH:mm:ss")
                }
                echo "Pipeline started at ${BUILD_TIMESTAMP}"
            }
        }
        stage("Greet") {
            steps {
                echo "${GREETING}"
            }
        }
        stage("Build") {
            steps {
                script {
                    // Simulating a build step
                    def buildResult = true
                    echo "Building the application..."
                    if (!buildResult) {
                        error "Build failed!"
                    }
                }
            }
        }
        stage("Test") {
            steps {
                echo "Running tests..."
                // Simulate test execution
                script {
                    def testResult = true
                    if (!testResult) {
                        error "Tests failed!"
                    }
                }
            }
        }
        stage("Deploy") {
            steps {
                echo "Deploying the application..."
                // Simulate deployment
            }
        }
    }
    post {
        always {
            echo "Pipeline completed at ${new Date().format("yyyy-MM-dd HH:mm:ss")}"
        }
        success {
            echo "Pipeline executed successfully!"
        }
        failure {
            echo "Pipeline failed. Please check the logs."
        }
    }
}



