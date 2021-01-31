
pipeline {
    agent any
    }
    stage {
        stage('Pull the code') {
            steps{
                sh "cd  $WORKSPACE"
                sh " ls -lahrt"
            }
        }
        stage('Deploy the code') {
            steps{
                sh "cp -rf $WORKSPACE /var/www/html/tutorgigs.io"
                sh "cd /var/www/html/tutorgigs.io  && ls -lahrt"
            }
        }
}
