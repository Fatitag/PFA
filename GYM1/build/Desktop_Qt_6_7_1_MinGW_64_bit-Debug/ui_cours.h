/********************************************************************************
** Form generated from reading UI file 'cours.ui'
**
** Created by: Qt User Interface Compiler version 6.7.1
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_COURS_H
#define UI_COURS_H

#include <QtCore/QVariant>
#include <QtWidgets/QApplication>
#include <QtWidgets/QDialog>
#include <QtWidgets/QHeaderView>
#include <QtWidgets/QTableWidget>

QT_BEGIN_NAMESPACE

class Ui_Cours
{
public:
    QTableWidget *tableWidget;

    void setupUi(QDialog *Cours)
    {
        if (Cours->objectName().isEmpty())
            Cours->setObjectName("Cours");
        Cours->resize(726, 382);
        Cours->setStyleSheet(QString::fromUtf8("QLineEdit{\n"
"background-color:orange;}"));
        tableWidget = new QTableWidget(Cours);
        tableWidget->setObjectName("tableWidget");
        tableWidget->setGeometry(QRect(20, 20, 691, 341));
        tableWidget->setStyleSheet(QString::fromUtf8("QWidget{background-color:white;}"));

        retranslateUi(Cours);

        QMetaObject::connectSlotsByName(Cours);
    } // setupUi

    void retranslateUi(QDialog *Cours)
    {
        Cours->setWindowTitle(QCoreApplication::translate("Cours", "Dialog", nullptr));
    } // retranslateUi

};

namespace Ui {
    class Cours: public Ui_Cours {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_COURS_H
