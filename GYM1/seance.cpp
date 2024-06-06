#include "seance.h"
#include "ui_seance.h"

Seance::Seance(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::Seance)  
{
    db=QSqlDatabase::database();

    ui->setupUi(this);
    // Set column count and headers
    ui->tableWidget->setColumnCount(6);//recuperer le tableau deja crer dans ui
    QStringList headers = {"id-seance", "date-seance", "id_cours", "id_coach", "heure_debut", "heure_fin"};
    ui->tableWidget->setHorizontalHeaderLabels(headers);
    db.open();
    QSqlQuery Qr ;
    Qr.prepare("select id_seance, date_seance, id_cours, id_coach, heure_debut, heure_fin from seance ");
    Qr.exec();
    int i=0;
    while(Qr.next()){
        ui->tableWidget->insertRow(i);
        QString idsea=Qr.value("id_seance").toString();
        QString ds=Qr.value("date_seance").toString();
        QString ic=Qr.value("id_cours").toString();
        QString icoa=Qr.value("id_coach").toString();
        QString hd=Qr.value("heure_debut").toString();
        QString hf=Qr.value("heure_fin").toString();
        // Example data to populate the new row
         ui->tableWidget->setItem(i, 0, new QTableWidgetItem(idsea));
         ui->tableWidget->setItem(i, 1, new QTableWidgetItem(ds));
         ui->tableWidget->setItem(i, 2, new QTableWidgetItem(ic));
         ui->tableWidget->setItem(i, 3, new QTableWidgetItem(icoa));
         ui->tableWidget->setItem(i, 4, new QTableWidgetItem(hd));
         ui->tableWidget->setItem(i, 5, new QTableWidgetItem(hf));
         i++;
    }//ligne par ligne
}

Seance::~Seance()
{
    delete ui;
}







