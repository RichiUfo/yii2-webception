How to install :

composer require godardth/yii2-webception 

config.php :


---
Components : 

    Configuration File Structure : 
    

    Models :
    
        - Codeception : Collection of test sites
            - sites
            - config
            - yaml
            - tally
            - tests
        
        - Site : One Test Site Entity which is a collection of tests
            - sites
            - hash
            methods :
            
        
        - Test : One Test Item
            - hash
            - filename
            - title
            - file
            - type
            - log
            - passed
            methods :
            - run()
            
    Controller : 
    