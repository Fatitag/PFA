#include "login.h"
#include "ui_login.h"

Login::Login(QWidget *parent)
    : QWidget(parent)
    , ui(new Ui::Login)
{
    ui->setupUi(this);

    db = QSqlDatabase::addDatabase("QMYSQL");
    db.setHostName("localhost");
    db.setPort(3307);
    db.setDatabaseName("projet_gym");
    db.setUserName("root");
    db.setPassword("");
}


Login::~Login()
{
    delete ui;
}

void Login::on_pushButton_clicked()
{

    QString username = ui->username->text();
    QString password = ui->password->text();
    if(username == "" || password == ""){
        QMessageBox::information(this,"echec","champ vide");

    }else{
        db.open();
        QSqlQuery qr;
        qr.prepare("SELECT `id_adherent`,  `passwrd_adherent`, `email_adherent` FROM `adherent`");
        qr.exec();
        while(qr.next()){
            QString email=qr.value("email_adherent").toString();
            QString pass=qr.value("passwrd_adherent").toString();
            if(email ==username &&pass==password){
                QString id=qr.value("id_adherent").toString();//nrodoh chaine de caractere
                MainWindow* m=new MainWindow(id);
                m->show();//kinkono dayrin pointeur laha9ach hiya widget
                this->hide();
            }


        }//line par line
 db.close();


    }


}




