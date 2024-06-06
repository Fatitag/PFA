#include "profil.h"
#include "ui_profil.h"

Profil::Profil(QString id,QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::Profil)
{
    ui->setupUi(this);
    id_adhe=id;
    db=QSqlDatabase::database();//recuperer la cnx de base de donn
    db.open();
    QSqlQuery pro;//sa declaration de query li ndiro fiha requete sql
    pro.prepare("Select nom_adherent,prenom_adherent,age_adherent from adherent where id_adherent=:id");
    pro.bindValue(":id",id_adhe);//remplacer le :id b id_adhe

    pro.exec();
    while(pro.next()){
        ui->Nom->setText(pro.value("nom_adherent").toString());//bach ndiroha f label
        ui->Prenom->setText(pro.value("prenom_adherent").toString());
        ui->Age->setText(pro.value("age_adherent").toString());
    }
    db.close();
}

Profil::~Profil()
{
    delete ui;
}




