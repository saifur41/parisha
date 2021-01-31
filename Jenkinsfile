
pipeline {
    agent any
    
    stages {
        stage('Pull the code') {
            steps{
                sh "cd  $WORKSPACE"
                sh " ls -lahrt"
            }
        }
        stage('Deploy the code') {
            steps{
                sh "rsync  -razh --update /var/lib/jenkins/workspace/tutor/tutorgigs.io/ /var/www/html/tutorgigs.io/"
                sh "sudo chown root:root /var/www/html/tutorgigs.io/ -R"
                sh "cd /var/www/html/tutorgigs.io/*  && ls -lahrt" 
            }
        }
}
   /* post {
        always {
            cleanWs()
            }   
            
    }
    */
    
}
