#include "cours.h"
#include "ui_cours.h"

Cours::Cours(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::Cours)
{
    ui->setupUi(this);
    db= QSqlDatabase::database();
    ui->tableWidget->setColumnCount(4);//recuperer le tableau deja crer dans ui
    QStringList headers = {"id_cours", "libele_cours", "description_cours", "id_type_cours"};
    ui->tableWidget->setHorizontalHeaderLabels(headers);
    db.open();
    QSqlQuery Qr ;
    Qr.prepare("SELECT `id_cours`, `libele_cours`, `description_cours`, `id_type_cours` FROM `cours` ");
    Qr.exec();
    int i=0;
    while(Qr.next()){
        ui->tableWidget->insertRow(i);
        QString idc=Qr.value("id_cours").toString();
        QString lc=Qr.value("libele_cours").toString();
        QString dc=Qr.value("description_cours").toString();
        QString idtc=Qr.value("id_type_cours").toString();
        // Example data to populate the new row
        ui->tableWidget->setItem(i, 0, new QTableWidgetItem(idc));
        ui->tableWidget->setItem(i, 1, new QTableWidgetItem(lc));
        ui->tableWidget->setItem(i, 2, new QTableWidgetItem(dc));
        ui->tableWidget->setItem(i, 3, new QTableWidgetItem(idtc));
        i++;
    }//ligne par ligne
}

Cours::~Cours()
{
    delete ui;
}



